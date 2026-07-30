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
            [
                'nip' => 'USR002',
                'nama' => 'Budi Santoso',
                'foto' => null,
                'jabatan' => 'Staf Administrasi',
                'email' => 'budi@pinbuk.test',
                'no_tlpn' => '081234567892',
                'status' => 'green',
                'level' => 'user',
                'password_plaintext' => 'password',
            ],
            [
                'nip' => 'USR003',
                'nama' => 'Siti Rahma',
                'foto' => null,
                'jabatan' => 'Pustakawan',
                'email' => 'siti@pinbuk.test',
                'no_tlpn' => '081234567893',
                'status' => 'yellow',
                'level' => 'user',
                'password_plaintext' => 'password',
            ],
            [
                'nip' => 'USR004',
                'nama' => 'Andi Wijaya',
                'foto' => null,
                'jabatan' => 'Staf Keuangan',
                'email' => 'andi@pinbuk.test',
                'no_tlpn' => '081234567894',
                'status' => 'red',
                'level' => 'user',
                'password_plaintext' => 'password',
            ],
            [
                'nip' => 'USR005',
                'nama' => 'Dewi Lestari',
                'foto' => null,
                'jabatan' => 'Staf Program',
                'email' => 'dewi@pinbuk.test',
                'no_tlpn' => '081234567895',
                'status' => 'black',
                'level' => 'user',
                'password_plaintext' => 'password',
            ],
            [
                'nip' => 'USR006',
                'nama' => 'Rizky Pratama',
                'foto' => null,
                'jabatan' => 'Analis Data',
                'email' => 'rizky@pinbuk.test',
                'no_tlpn' => '081234567896',
                'status' => 'green',
                'level' => 'user',
                'password_plaintext' => 'password',
            ],
            [
                'nip' => 'USR007',
                'nama' => 'Nadia Putri',
                'foto' => null,
                'jabatan' => 'Staf Layanan',
                'email' => 'nadia@pinbuk.test',
                'no_tlpn' => '081234567897',
                'status' => 'yellow',
                'level' => 'user',
                'password_plaintext' => 'password',
            ],
            [
                'nip' => 'USR008',
                'nama' => 'Fajar Nugroho',
                'foto' => null,
                'jabatan' => 'Staf Umum',
                'email' => 'fajar@pinbuk.test',
                'no_tlpn' => '081234567898',
                'status' => 'green',
                'level' => 'user',
                'password_plaintext' => 'password',
            ],
            [
                'nip' => 'USR009',
                'nama' => 'Maya Sari',
                'foto' => null,
                'jabatan' => 'Staf Komunikasi',
                'email' => 'maya@pinbuk.test',
                'no_tlpn' => '081234567899',
                'status' => 'gray',
                'level' => 'user',
                'password_plaintext' => 'password',
            ],
            [
                'nip' => 'USR010',
                'nama' => 'Dimas Saputra',
                'foto' => null,
                'jabatan' => 'Staf Operasional',
                'email' => 'dimas@pinbuk.test',
                'no_tlpn' => '081234567900',
                'status' => 'red',
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
