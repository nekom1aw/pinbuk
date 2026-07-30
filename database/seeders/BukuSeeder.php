<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BukuSeeder extends Seeder
{
    /**
     * Seed koleksi buku contoh untuk katalog dan peminjaman.
     */
    public function run(): void
    {
        $books = [
            ['B-00001', 'Laravel untuk Pemula', 'Ahmad Fauzi', 2024, 'Informatika', 'Teknologi', 'Pemrograman', 'Web', 5, 'Baru', ['laravel', 'php', 'web']],
            ['B-00002', 'Membangun API Modern', 'Rina Kurnia', 2023, 'Media Digital', 'Teknologi', 'Pemrograman', 'Web', 3, 'Baru', ['api', 'backend', 'web']],
            ['B-00003', 'Aplikasi Mobile Praktis', 'Dedi Irawan', 2022, 'Tekno Press', 'Teknologi', 'Pemrograman', 'Mobile', 4, 'Bekas', ['mobile', 'aplikasi']],
            ['B-00004', 'Dasar Data Science', 'Nina Oktavia', 2024, 'Data Nusantara', 'Teknologi', 'Data dan AI', 'Data Science', 2, 'Baru', ['data', 'statistik']],
            ['B-00005', 'Kecerdasan Buatan Terapan', 'Bagus Maulana', 2025, 'Cerdas Media', 'Teknologi', 'Data dan AI', 'Kecerdasan Buatan', 3, 'Baru', ['ai', 'machine-learning']],
            ['B-00006', 'Seni Memimpin Tim', 'Indra Gunawan', 2021, 'Bisnis Utama', 'Bisnis', 'Manajemen', 'Kepemimpinan', 4, 'Bekas', ['manajemen', 'leadership']],
            ['B-00007', 'Manajemen Operasional', 'Sarah Amelia', 2020, 'Mitra Bisnis', 'Bisnis', 'Manajemen', 'Operasional', 2, 'Bekas', ['operasional', 'bisnis']],
            ['B-00008', 'Akuntansi Sederhana', 'Hendra Saputra', 2023, 'Finansial Press', 'Bisnis', 'Keuangan', 'Akuntansi', 5, 'Baru', ['akuntansi', 'keuangan']],
            ['B-00009', 'Investasi untuk Semua', 'Maya Permata', 2024, 'Finansial Press', 'Bisnis', 'Keuangan', 'Investasi', 3, 'Baru', ['investasi', 'keuangan']],
            ['B-00010', 'Komunikasi Efektif', 'Tania Putri', 2022, 'Edu Media', 'Pendidikan', 'Pengembangan Diri', 'Komunikasi', 4, 'Bekas', ['komunikasi', 'softskill']],
            ['B-00011', 'Produktif Tanpa Stres', 'Reza Prakoso', 2025, 'Edu Media', 'Pendidikan', 'Pengembangan Diri', 'Produktivitas', 3, 'Baru', ['produktivitas', 'pengembangan-diri']],
            ['B-00012', 'Metodologi Penelitian', 'Prof. Ari Wibowo', 2021, 'Akademia', 'Pendidikan', 'Referensi', 'Metodologi', 5, 'Bekas', ['penelitian', 'referensi']],
            ['B-00013', 'Senja di Jakarta', 'Larasati', 2020, 'Pustaka Kita', 'Fiksi', 'Novel', 'Indonesia', 2, 'Bekas', ['novel', 'indonesia']],
            ['B-00014', 'Perjalanan Sang Penemu', 'Daniel Hartono', 2023, 'Pustaka Dunia', 'Fiksi', 'Novel', 'Terjemahan', 3, 'Baru', ['novel', 'terjemahan']],
            ['B-00015', 'Kumpulan Cerita Hari Ini', 'Ayu Sekar', 2024, 'Pustaka Kita', 'Fiksi', 'Cerita Pendek', 'Modern', 4, 'Baru', ['cerpen', 'modern']],
        ];

        $now = now();

        foreach ($books as [$kode, $judul, $penulis, $tahun, $penerbit, $kategori, $sub1, $sub2, $stok, $kondisi, $tags]) {
            $kategoriId = DB::table('kategori_buku')->where('nama', $kategori)->value('id');
            $sub1Id = DB::table('sub_kategori_buku1')
                ->where('nama', $sub1)
                ->where('id_kategori', $kategoriId)
                ->value('id');
            $sub2Id = DB::table('sub_kategori_buku2')
                ->where('nama', $sub2)
                ->where('id_sub_kategori1', $sub1Id)
                ->value('id');

            DB::table('buku')->updateOrInsert(
                ['kode_uniq' => $kode],
                [
                    'nama_buku' => $judul,
                    'penulis' => $penulis,
                    'terbit_tahun' => $tahun,
                    'penerbit' => $penerbit,
                    'ringkasan' => "Buku contoh {$judul} untuk pengujian katalog dan transaksi peminjaman.",
                    'foto_buku' => null,
                    'file' => null,
                    'jenis_buku' => 'cetak',
                    'position_foto' => 'center',
                    'id_kategori_buku' => $kategoriId,
                    'sub_kategori1' => $sub1Id,
                    'sub_kategori2' => $sub2Id,
                    'stok' => $stok,
                    'tampil' => 'ya',
                    'qr_code' => null,
                    'kondisi' => $kondisi,
                    'catatan' => 'Data buku contoh dari seeder.',
                    'tags' => json_encode($tags),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
