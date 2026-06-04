<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kampus;

class KampusSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [1, 'UPN "Veteran" Jawa Timur', 'Surabaya', 'A', 'Rp. 1.000.000 - Rp. 7.000.000 / SMT', 'upnvjt.png', '2026-04-11 10:06:48'],
            [3, 'Institut Teknologi Bandung', 'Bandung', 'Unggul', 'Rp. 1.000.000 - Rp. 20.000.000 / SMT', 'itb.png', '2026-04-11 11:43:19'],
            [4, 'Universitas Indonesia', 'Jakarta', 'Unggul', 'Rp. 1.000.000 - Rp. 25.000.000 / SMT', 'ui.png', '2026-04-11 11:48:43'],
            [5, 'Universitas Gadjah Mada', 'Yogyakarta', 'Unggul', 'Rp. 1.000.000 - Rp. 20.000.000 / SMT', 'ugm.jfif', '2026-04-12 14:32:09'],
            [6, 'Universitas Diponegoro', 'Semarang', 'Unggul', 'Rp. 1.000.000 - Rp. 15.000.000 / SMT', 'undip.jfif', '2026-04-12 14:32:09'],
            [7, 'Universitas Surabaya', 'Surabaya', 'Unggul', 'Rp. 1.000.000 - Rp. 15.000.000 / SMT', 'unesa.jfif', '2026-04-12 14:36:45'],
            [8, 'Universitas Brawijaya', 'Malang', 'Unggul', 'Rp. 1.000.000 - Rp. 15.000.000 / SMT', 'ub.jfif', '2026-04-12 14:38:22'],
        ];

        foreach ($data as $item) {
            Kampus::updateOrCreate(
                ['id_kampus' => $item[0]],
                [
                    'nama_kampus' => $item[1],
                    'lokasi' => $item[2],
                    'akreditasi' => $item[3],
                    'estimasi_biaya' => $item[4],
                    'logo_kampus' => $item[5],
                    'created_at' => $item[6],
                ]
            );
        }
    }
}