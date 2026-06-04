<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hasil_Tes;

class Hasil_TesSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [2, 1, 1, 60, '2026-04-11 12:49:46'],
            [3, 1, 10, 80, '2026-04-11 13:04:32'],
            [4, 2, 10, 80, '2026-04-12 11:03:30'],
            [5, 2, 1, 0, '2026-04-12 11:04:39'],
            [6, 2, 10, 80, '2026-04-12 11:05:29'],
            [7, 2, 10, 80, '2026-04-12 13:17:16'],
            [8, 2, 10, 80, '2026-04-12 13:32:38'],
            [9, 2, 10, 80, '2026-04-12 13:38:10'],
            [10, 2, 10, 60, '2026-04-12 13:56:11'],
            [11, 2, 2, 54, '2026-04-12 13:56:38'],
            [12, 2, 13, 54, '2026-04-12 13:58:00'],
            [13, 2, 7, 38, '2026-04-12 14:05:21'],
        ];

        foreach ($data as $item) {
            Hasil_Tes::updateOrCreate(
                ['id_hasil' => $item[0]],
                [
                    'id_user' => $item[1],
                    'id_jurusan' => $item[2],
                    'skor_kecocokan' => $item[3],
                    'tanggal_tes' => $item[4],
                ]
            );
        }
    }
}