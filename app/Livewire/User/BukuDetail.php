<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class BukuDetail extends Component
{
    use WithPagination;

    public $id;
    public $buku;
    public $user_id;
    public $sudahDipinjam;
    public $kode_uniq;
    public $tanggal_pinjam;
    public $tanggal_kembali;
    public $varianBuku = [];

    public function mount($id)
    {
        $this->user_id = session('user_id');
        if (!$this->user_id) {
            abort(403, 'Unauthorized.');
        }

        $this->id = $id;

        $this->buku = DB::table('buku')
            ->leftJoin('kategori_buku', 'buku.id_kategori_buku', '=', 'kategori_buku.id')
            ->where('buku.id', $id)
            ->selectRaw('
                buku.*,
                kategori_buku.nama AS nama_kategori,
                (
                    SELECT SUM(stok)
                    FROM buku b2
                    WHERE b2.nama_buku = buku.nama_buku
                      AND b2.ringkasan = buku.ringkasan
                ) AS total_stok
            ')
            ->first();

        $this->varianBuku = DB::table('buku')
            ->where('nama_buku', $this->buku->nama_buku)
            ->where('ringkasan', $this->buku->ringkasan)
            ->get();

        $this->sudahDipinjam = DB::table('peminjaman')
            ->where('user_id', $this->user_id)
            ->where('kode_uniq', $this->buku->kode_uniq)
            ->where('status', 'Dipinjam')
            ->exists();
    }

    protected function otherBooksQuery()
    {
        return DB::table('peminjaman')
            ->join('buku', 'peminjaman.kode_uniq', '=', 'buku.kode_uniq')
            ->selectRaw('
                MIN(buku.id) as id,
                buku.nama_buku,
                buku.ringkasan,
                MIN(buku.foto_buku) as foto_buku,
                SUM(buku.stok) as total_stok,
                COUNT(peminjaman.id) as total_pinjam
            ')
            ->where('buku.id', '!=', $this->id)
            ->where('buku.id_kategori_buku', $this->buku->id_kategori_buku)
            ->groupBy('buku.nama_buku', 'buku.ringkasan')
            ->orderByDesc('total_pinjam');
    }

    public function pinjamBuku()
    {

        $adaJatuhTempo = DB::table('peminjaman')
            ->where('user_id', $this->user_id)
            ->whereRaw('LOWER(status) = ?', ['jatuh tempo'])
            ->exists();

        if ($adaJatuhTempo) {
            session()->flash('error', 'Anda memiliki pinjaman yang jatuh tempo. Harap kembalikan terlebih dahulu sebelum meminjam buku lain.');
            return;
        }

        $jumlahPinjaman = DB::table('peminjaman')
            ->where('user_id', $this->user_id)
            ->whereIn('status', ['request', 'Dipinjam', 'Silahkan Diambil'])
            ->count();

        if ($jumlahPinjaman >= 3) {
            session()->flash('error', 'Anda hanya bisa meminjam maksimal 3 buku dalam satu waktu.');
            return;
        }

        
        $sudahAdaPinjamanSerupa = DB::table('peminjaman')
            ->join('buku', 'peminjaman.kode_uniq', '=', 'buku.kode_uniq')
            ->where('peminjaman.user_id', $this->user_id)
            ->whereIn('peminjaman.status', ['request', 'Dipinjam', 'Silahkan Diambil'])
            ->where('buku.nama_buku', $this->buku->nama_buku)
            ->where('buku.ringkasan', $this->buku->ringkasan)
            ->exists();

        if ($sudahAdaPinjamanSerupa) {
            session()->flash('error', 'Anda sudah memiliki peminjaman aktif untuk buku ini.');
            return;
        }

        $bukuCetak = DB::table('buku')
            ->where('nama_buku', $this->buku->nama_buku)
            ->where('ringkasan', $this->buku->ringkasan)
            ->where('jenis_buku', 'cetak')
            ->where('stok', '>', 0)
            ->orderBy('id')
            ->first();

        if (!$bukuCetak) {
            session()->flash('error', 'Stok buku cetak tidak tersedia.');
            return;
        }

        DB::table('peminjaman')->insert([
            'user_id'         => $this->user_id,
            'kode_uniq'       => $bukuCetak->kode_uniq,
            'tanggal_pinjam'  => now()->toDateString(),
            'tanggal_kembali' => now()->addDays(30)->toDateString(),
            'keperluan'       => ' ',
            'catatan'         => ' ',
            'harga_sewa'      => 0,
            'invoice'         => ' ',
            'status'          => 'request',
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        DB::table('buku')
            ->where('id', $bukuCetak->id)
            ->decrement('stok', 1);

        session()->flash('success', 'Permintaan peminjaman berhasil dikirim.');
        $this->sudahDipinjam = true;

        return redirect('/user/peminjaman');
    }


    public function render()
    {
        return view('livewire.user.buku-detail', [
            'otherBooks' => $this->otherBooksQuery()->paginate(10),
            'varianBuku' => $this->varianBuku,
        ]);
    }
}
