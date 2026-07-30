<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeminjamanSeeder extends Seeder
{
    /**
     * Seed riwayat peminjaman dengan beragam status dan kondisi.
     */
    public function run(): void
    {
        $loans = [
            ['user@pinbuk.test', 'B-00001', -2, 28, 'Request', null],
            ['budi@pinbuk.test', 'B-00002', -5, 25, 'Silahkan di Ambil', null],
            ['siti@pinbuk.test', 'B-00003', -10, 20, 'Dipinjam', null],
            ['andi@pinbuk.test', 'B-00004', -45, -15, 'jatuh tempo', null],
            ['dewi@pinbuk.test', 'B-00005', -70, -40, 'Kembali', 'baik'],
            ['rizky@pinbuk.test', 'B-00006', -50, -20, 'Kembali', 'rusak'],
            ['nadia@pinbuk.test', 'B-00007', -35, -5, 'req_perpanjang', null],
            ['fajar@pinbuk.test', 'B-00008', -90, -60, 'Hilang', 'hilang'],
            ['maya@pinbuk.test', 'B-00009', -8, 22, 'Dipinjam', null],
            ['dimas@pinbuk.test', 'B-00010', -60, -30, 'Kembali', 'baik'],
            ['budi@pinbuk.test', 'B-00011', -1, 29, 'Request', null],
            ['siti@pinbuk.test', 'B-00012', -20, 10, 'Dipinjam', null],
            ['andi@pinbuk.test', 'B-00013', -40, -10, 'jatuh tempo', null],
            ['rizky@pinbuk.test', 'B-00014', -120, -90, 'Kembali', 'baik'],
            ['nadia@pinbuk.test', 'B-00015', -3, 27, 'Silahkan di Ambil', null],
            ['user@pinbuk.test', 'B-00006', -80, -50, 'Kembali', 'rusak'],
            ['maya@pinbuk.test', 'B-00002', -32, -2, 'req_perpanjang', null],
            ['dimas@pinbuk.test', 'B-00005', -15, 15, 'Dipinjam', null],
        ];

        foreach ($loans as $index => [$email, $kodeBuku, $hariPinjam, $hariKembali, $status, $kondisi]) {
            $userId = DB::table('pengguna')->where('email', $email)->value('id');
            $nomor = str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT);
            $invoice = "INV-DEMO-{$nomor}";
            $tanggalPinjam = now()->addDays($hariPinjam)->toDateString();
            $tanggalKembali = now()->addDays($hariKembali)->toDateString();

            DB::table('peminjaman')->updateOrInsert(
                ['invoice' => $invoice],
                [
                    'user_id' => $userId,
                    'kode_uniq' => $kodeBuku,
                    'tanggal_pinjam' => $tanggalPinjam,
                    'tanggal_kembali' => $tanggalKembali,
                    'keperluan' => 'Peminjaman buku untuk membaca dan referensi.',
                    'catatan' => "Data peminjaman contoh {$nomor}.",
                    'harga_sewa' => 0,
                    'status' => $status,
                    'kondisi' => $kondisi,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
