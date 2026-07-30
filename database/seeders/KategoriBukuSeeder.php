<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriBukuSeeder extends Seeder
{
    /**
     * Seed delapan kategori utama dengan ID tetap agar URL katalog konsisten.
     */
    public function run(): void
    {
        $categories = [
            1 => 'Hutan',
            2 => 'Kebun',
            3 => 'Tambang & Energi',
            4 => 'Laut',
            5 => 'Hukum',
            6 => 'Keuangan',
            7 => 'Novel',
            8 => 'Lainnya',
        ];

        foreach ($categories as $id => $name) {
            DB::table('kategori_buku')->updateOrInsert(
                ['id' => $id],
                [
                    'nama' => $name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
