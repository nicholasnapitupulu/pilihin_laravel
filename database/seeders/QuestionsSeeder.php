<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Questions;

class QuestionsSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [1, 'Saya merasa tertarik memahami bagaimana suatu sistem bekerja, seperti program komputer, mesin, atau alur kerja organisasi.', 'IT, Kedokteran, Teknik'],
            [2, 'Saya menikmati kegiatan membantu orang lain menyelesaikan masalah pribadi atau emosional mereka.', 'Psikologi, Pendidikan'],
            [3, 'Saya tertarik menciptakan sesuatu yang baru, seperti desain, tulisan, atau ide kreatif.', 'Desain, Seni'],
            [4, 'Saya merasa nyaman memimpin kelompok dan mengambil keputusan penting dalam suatu tim.', 'Manajemen, Bisnis'],
            [5, 'Saya menyukai pekerjaan yang membutuhkan ketelitian tinggi, seperti mengelola data atau membuat laporan.', 'Akuntansi, Administrasi'],
            [6, 'Saya tertarik melakukan eksperimen, penelitian, atau analisis untuk menemukan jawaban dari suatu masalah.', 'IT, Kedokteran, Teknik'],
            [7, 'Saya menikmati aktivitas yang melibatkan kerja langsung di lapangan atau menggunakan alat dan teknologi.', 'Teknik, Otomotif'],
            [8, 'Saya tertarik pada dunia bisnis, seperti menjual produk, membuat strategi pemasaran, atau membangun usaha.', 'Manajemen, Bisnis'],
            [9, 'Saya merasa puas ketika bisa mengajarkan sesuatu kepada orang lain atau berbagi ilmu.', 'Psikologi, Pendidikan'],
            [10, 'Saya senang mengikuti aturan yang jelas dan bekerja dengan prosedur yang terstruktur.', 'Akuntansi, Administrasi'],
        ];

        foreach ($data as $item) {
            Questions::updateOrCreate(
                ['id_soal' => $item[0]],
                [
                    'teks_pertanyaan' => $item[1],
                    'kategori_minat' => $item[2],
                ]
            );
        }
    }
}