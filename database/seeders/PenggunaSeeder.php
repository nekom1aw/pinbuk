<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    /**
     * Seed akun pengguna aplikasi.
     */
    public function run(): void
    {
        $now = now();

        $pengguna = [
            [
                'nip' => 'ADM001',
                'nama' => 'Administrator',
                'foto' => null,
                'jabatan' => 'Admin',
                'email' => 'admin@pinbuk.test',
                'no_tlpn' => '081234567890',
                'status' => 'green',
                'level' => 'admin',
                'password_plaintext' => 'password',
            ],
            [
                'nip' => 'USR001',
                'nama' => 'User Pinbuk',
                'foto' => null,
                'jabatan' => 'Anggota',
                'email' => 'user@pinbuk.test',
                'no_tlpn' => '081234567891',
                'status' => 'gray',
                'level' => 'user',
                'password_plaintext' => 'password',
            ],
        ];

        foreach ($pengguna as $user) {
            DB::table('pengguna')->updateOrInsert(
                ['email' => $user['email']],
                [
                    'nip' => $user['nip'],
                    'nama' => $user['nama'],
                    'foto' => $user['foto'],
                    'jabatan' => $user['jabatan'],
                    'no_tlpn' => $user['no_tlpn'],
                    'status' => $user['status'],
                    'level' => $user['level'],
                    'password' => Hash::make($user['password_plaintext']),
                    'password_plaintext' => $user['password_plaintext'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
