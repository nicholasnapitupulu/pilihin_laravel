<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            JurusanSeeder::class,
            KampusSeeder::class,
            QuestionsSeeder::class,
            RoadmapSeeder::class,
            Relasi_Kampus_JurusanSeeder::class,
            Hasil_TesSeeder::class,
        ]);
    }
}