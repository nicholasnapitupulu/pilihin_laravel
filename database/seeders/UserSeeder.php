<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id_user' => 1,
                'nama_lengkap' => 'faiz',
                'email' => 'faiz@gmail.com',
                'password' => 'faiz1234',
                'asal_sekolah' => 'SMAN 2 BOJONEGORO',
                'foto_profil' => 'foto_1_1781028900.jpg',
                'role' => 'user',
                'created_at' => '2026-04-09 12:11:03',
            ],
            [
                'id_user' => 2,
                'nama_lengkap' => 'uji coba',
                'email' => 'ujicoba@gmail.com',
                'password' => 'ujicoba',
                'asal_sekolah' => 'SMAN 1 SURABAYA',
                'role' => 'user',
                'created_at' => '2026-04-12 10:42:01',
            ],
            [
                'id_user' => 3,
                'nama_lengkap' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => 'admin',
                'asal_sekolah' => 'SMA 2 Jakarta',
                'role' => 'admin',
                'created_at' => '2026-04-12 10:42:01',
            ],
            [
                'id_user' => 4,
                'nama_lengkap' => 'superadmin',
                'email' => 'superadmin@gmail.com',
                'password' => 'superadmin',
                'asal_sekolah' => 'SMA 3 Jakarta',
                'role' => 'superadmin',
                'created_at' => '2026-04-12 10:42:01',
            ],
            [
                'id_user' => 5,
                'nama_lengkap' => 'naufal',
                'email' => 'naufal@gmail.com',
                'password' => 'naufal123',
                'asal_sekolah' => 'SMA 1 Sidoarjo',
                'role' => 'user',
                'created_at' => '2026-05-12 10:42:01',
            ],
            [
                'id_user' => 6,
                'nama_lengkap' => 'nicholas',
                'email' => 'nicholas@gmail.com',
                'password' => 'nicholas123',
                'asal_sekolah' => 'SMA 2 Jakarta',
                'role' => 'user',
                'created_at' => '2026-05-12 10:44:01',
            ]

        ];

        foreach ($data as $item) {
            User::updateOrCreate(['id_user' => $item['id_user']], $item);
        }
    }
}