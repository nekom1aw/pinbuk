<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
// use SimpleSoftwareIO\QrCode\Facades\QrCode; 
use Illuminate\Validation\Rule;

class BukuTambah extends Component
{
    use WithFileUploads;

    public $kategori;
    public $nama_buku, $penulis, $terbit_tahun, $penerbit;
    public $ringkasan, $foto_buku;
    public $kondisi, $catatan;
    public $list_kategori, $list_kondisi;
    public $newTag, $tags = [];
    public $tampil = 'tidak';
    public $position_foto = 'center';
    public $jenis_buku, $file;

    public function mount()
    {
        $this->list_kategori = DB::table('kategori_buku')->select('id', 'nama')->get();
        $this->list_kondisi = collect(['Baru', 'Bekas']);
    }

    public function addTag()
    {
        if (!empty($this->newTag) && str_word_count($this->newTag) === 1) {
            if (!in_array($this->newTag, $this->tags)) {
                $this->tags[] = $this->newTag;
            }
        }
        $this->newTag = ''; // Reset input tag
    }

    public function removeTag($tag)
    {
        $this->tags = array_filter($this->tags, fn($item) => $item !== $tag);
    }

    public function store()
    {
        $rules = [
            'nama_buku' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'terbit_tahun' => 'required|digits:4|integer|min:1000|max:' . date('Y'),
            'penerbit' => 'required|string|max:255',
            'ringkasan' => 'nullable|string',
            'jenis_buku' => 'required|in:digital,cetak',
            'kategori' => 'required|exists:kategori_buku,id',
            'foto_buku' => 'nullable|image|max:2048',
            'kondisi' => ['required', Rule::in(['Baru', 'Bekas'])],
            'catatan' => 'nullable|string',
            'tags' => 'nullable|array|max:5',
            'position_foto' => ['required', Rule::in(['top', 'center', 'bottom'])],
            'tampil' => 'required|in:ya,tidak',
        ];

        // Tambahkan aturan file hanya jika buku digital
        if ($this->jenis_buku === 'digital') {
            $rules['file'] = 'required|file|mimes:pdf|max:20480';
        }

        $this->validate($rules);

        
        $lastBook = DB::table('buku')->latest('id')->first();
        $nextNumber = $lastBook ? intval(substr($lastBook->kode_uniq, 2)) + 1 : 1;
        $kodeUniq = 'B-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        $filePath = null;
        if ($this->jenis_buku === 'digital' && $this->file) {
            $storedPath = $this->file->store('pdf', 'public');
            $filePath = '/storage/' . $storedPath;
        }


        $fotoBukuPath = null;
        if ($this->foto_buku) {
            $path = $this->foto_buku->store('images/buku', 'public');
            $fotoBukuPath = '/storage/' . $path;
        }



        $bukuId = DB::table('buku')->insertGetId([
            'kode_uniq' => $kodeUniq,
            'nama_buku' => $this->nama_buku,
            'penulis' => $this->penulis,
            'terbit_tahun' => $this->terbit_tahun,
            'penerbit' => $this->penerbit,
            'ringkasan' => $this->ringkasan,
            'foto_buku' => $fotoBukuPath,
            'position_foto' => $this->position_foto,
            'id_kategori_buku' => $this->kategori,
            'stok' => 1,
            'tampil' => $this->tampil,
            'kondisi' => $this->kondisi,
            'catatan' => $this->catatan,
            'tags' => json_encode($this->tags),
            'jenis_buku' => $this->jenis_buku,
            'file' => $filePath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        require_once public_path('phpqrcode/qrlib.php');
        // Buat QR code
        $adminUrl = url('/admin/buku/' . $bukuId . '/detail');
        $qrRelPath = 'qr_codes/buku/qr_' . $bukuId . '.png';
        $qrFullPath = storage_path('app/public/' . $qrRelPath);

        if (!file_exists(dirname($qrFullPath))) {
            mkdir(dirname($qrFullPath), 0755, true);
        }


        \QRcode::png($adminUrl, $qrFullPath, QR_ECLEVEL_L, 5, 2);


        DB::table('buku')->where('id', $bukuId)->update([
            'qr_code' => '/storage/' . $qrRelPath
        ]);

        session()->flash('message', 'Buku berhasil ditambahkan dengan kode unik: ' . $kodeUniq . '!');
        return redirect()->to('/admin/buku');
    }

    public function render()
    {
        return view('livewire.admin.buku-tambah');
    }
}
