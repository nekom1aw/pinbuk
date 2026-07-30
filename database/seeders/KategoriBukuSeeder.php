<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriBukuSeeder extends Seeder
{
    /**
     * Seed kategori beserta dua tingkat subkategori buku.
     */
    public function run(): void
    {
        $data = [
            'Teknologi' => [
                'Pemrograman' => ['Web', 'Mobile'],
                'Data dan AI' => ['Data Science', 'Kecerdasan Buatan'],
            ],
            'Bisnis' => [
                'Manajemen' => ['Kepemimpinan', 'Operasional'],
                'Keuangan' => ['Akuntansi', 'Investasi'],
            ],
            'Pendidikan' => [
                'Pengembangan Diri' => ['Komunikasi', 'Produktivitas'],
                'Referensi' => ['Metodologi', 'Bahasa'],
            ],
            'Fiksi' => [
                'Novel' => ['Indonesia', 'Terjemahan'],
                'Cerita Pendek' => ['Klasik', 'Modern'],
            ],
        ];

        $now = now();

        foreach ($data as $kategoriNama => $subKategori) {
            DB::table('kategori_buku')->updateOrInsert(
                ['nama' => $kategoriNama],
                ['updated_at' => $now, 'created_at' => $now]
            );

            $kategoriId = DB::table('kategori_buku')
                ->where('nama', $kategoriNama)
                ->value('id');

            foreach ($subKategori as $sub1Nama => $sub2List) {
                DB::table('sub_kategori_buku1')->updateOrInsert(
                    ['nama' => $sub1Nama, 'id_kategori' => $kategoriId],
                    ['updated_at' => $now, 'created_at' => $now]
                );

                $sub1Id = DB::table('sub_kategori_buku1')
                    ->where('nama', $sub1Nama)
                    ->where('id_kategori', $kategoriId)
                    ->value('id');

                foreach ($sub2List as $sub2Nama) {
                    DB::table('sub_kategori_buku2')->updateOrInsert(
                        ['nama' => $sub2Nama, 'id_sub_kategori1' => $sub1Id],
                        ['updated_at' => $now, 'created_at' => $now]
                    );
                }
            }
        }
    }
}
