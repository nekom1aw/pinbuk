<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeminjamanIndex extends Component
{
    public $peminjamanList;
    public $jenis;

    public function mount()
    {
        $userId = session('user_id');

        if (!$userId) {
            abort(403, 'Unauthorized.');
        }

        $this->peminjamanList = DB::table('peminjaman')
            ->join('pengguna', 'peminjaman.user_id', '=', 'pengguna.id')
            ->where('peminjaman.user_id', $userId)
            ->orderByDesc('peminjaman.tanggal_pinjam')
            ->select('peminjaman.*', 'pengguna.nama as nama_peminjam')
            ->get();

        foreach ($this->peminjamanList as $item) {
            $item->jenis = $this->getJenis($item->kode_uniq);

            if ($item->jenis === 'Buku') {
                $data = DB::table('buku')->where('kode_uniq', $item->kode_uniq)->first();

                if ($data) {
                    $item->buku_id = $data->id; // ✅ Tambahkan ini
                    $item->nama = $data->nama_buku ?? 'Tidak ditemukan';
                    $item->gambar = $data->foto_buku ?? 'https://via.placeholder.com/60';
                } else {
                    $item->buku_id = null; // ✅ Supaya aman
                    $item->nama = 'Tidak ditemukan';
                    $item->gambar = 'https://via.placeholder.com/60';
                }
            } else {
                $item->buku_id = null; // ✅ Default kalau bukan buku
                $item->nama = 'Belum tersedia';
                $item->gambar = 'https://via.placeholder.com/60';
            }

            $status = strtolower($item->status);
            $tanggalKembali = Carbon::parse($item->tanggal_kembali);

            if (in_array($status, ['dipinjam', 'silahkan di ambil', 'request']) && $tanggalKembali->isPast()) {
                DB::table('peminjaman')
                    ->where('id', $item->id)
                    ->update(['status' => 'jatuh tempo']);

                $item->status = 'jatuh tempo';
            }
        }
    }

    public function perpanjang($id)
    {
        $peminjaman = DB::table('peminjaman')->where('id', $id)->first();

        if (!$peminjaman || $peminjaman->status !== 'jatuh tempo') {
            session()->flash('error', 'Data peminjaman tidak valid.');
            return;
        }

        DB::table('peminjaman')->where('id', $id)->update([
            'status' => 'req_perpanjang',
            'updated_at' => now(),
        ]);

        session()->flash('success', 'Permintaan perpanjangan telah dikirim.');
    }


    public function getJenis($kodeUniq)
    {
        if (strpos($kodeUniq, 'A-') === 0) {
            return 'Aset';
        } elseif (strpos($kodeUniq, 'B-') === 0) {
            return 'Buku';
        }

        return 'Unknown';
    }

    public function redirectKeDetailBuku($kodeUnik)
    {
        $buku = DB::table('buku')->where('kode_uniq', $kodeUnik)->first();

        if ($buku) {
            return redirect()->route('user.buku.detail', $buku->id);
        }

        session()->flash('error', 'Buku tidak ditemukan');
    }

    public function render()
    {
        return view('livewire.user.peminjaman-index', [
            'peminjamanList' => $this->peminjamanList
        ]);
    }
}
