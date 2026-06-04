<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Relasi_Kampus_JurusanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [2, 1, 1], [3, 3, 1], [4, 4, 1], [5, 1, 2], [6, 1, 3], [7, 1, 4],
            [8, 1, 8], [9, 1, 9], [10, 1, 10], [11, 1, 11], [12, 1, 12],
            [13, 1, 13], [14, 1, 16], [15, 1, 17], [16, 1, 18], [17, 4, 3],
            [18, 4, 4], [19, 4, 5], [20, 4, 6], [21, 4, 7], [22, 4, 8],
            [23, 4, 9], [24, 4, 10], [25, 4, 11], [26, 4, 12], [27, 4, 13],
            [28, 4, 14], [29, 4, 15], [30, 4, 16], [31, 4, 17], [32, 4, 18],
            [33, 4, 20]
        ];

        foreach ($data as $item) {
            DB::table('relasi_kampus_jurusan')->updateOrInsert(
                ['id_relasi' => $item[0]],
                [
                    'id_kampus' => $item[1],
                    'id_jurusan' => $item[2],
                ]
            );
        }
    }
}