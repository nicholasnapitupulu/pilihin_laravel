<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [1, 'Sistem Informasi', 'Menggabungkan teknologi informasi dengan kebutuhan bisnis.', 'IT, Bisnis', 'System Analyst, IT Consultant, Business Analyst', null],
            [2, 'Teknik Informatika', 'Mempelajari pemrograman, pengembangan software, dan teknologi komputer.', 'IT', 'Software Engineer, Web Developer, Data Scientist, AI Engineer', null],
            [3, 'Teknologi Informasi', 'Fokus pada pengelolaan infrastruktur IT dan jaringan komputer.', 'IT', 'Network Engineer, IT Support, Cybersecurity Analyst', null],
            [4, 'Kedokteran', 'Mempelajari diagnosis, pengobatan, dan pencegahan penyakit.', 'Kedokteran', 'Dokter Umum, Dokter Spesialis', null],
            [5, 'Keperawatan', 'Fokus pada perawatan pasien dan pelayanan kesehatan.', 'Kedokteran', 'Perawat, Tenaga Medis', null],
            [6, 'Psikologi', 'Mempelajari perilaku manusia dan proses mental.', 'Psikologi', 'Psikolog, HRD, Konselor', null],
            [7, 'Bimbingan Konseling', 'Fokus pada membantu individu dalam masalah pendidikan dan pribadi.', 'Psikologi, Pendidikan', 'Konselor, Guru BK', null],
            [8, 'Manajemen', 'Mempelajari pengelolaan organisasi dan strategi bisnis.', 'Manajemen, Bisnis', 'Manager, Entrepreneur', null],
            [9, 'Kewirausahaan', 'Fokus pada membangun dan mengembangkan usaha.', 'Bisnis, Manajemen', 'Pengusaha, Startup Founder', null],
            [10, 'Akuntansi', 'Berfokus pada laporan dan analisis keuangan.', 'Akuntansi', 'Akuntan, Auditor', null],
            [11, 'Administrasi Bisnis', 'Mengelola kegiatan operasional dan administrasi bisnis.', 'Administrasi, Bisnis', 'Admin, Office Manager', null],
            [12, 'Administrasi Publik', 'Mengelola kebijakan dan layanan publik.', 'Administrasi', 'ASN, Staff Pemerintahan', null],
            [13, 'Desain Komunikasi Visual', 'Menciptakan karya visual untuk komunikasi.', 'Desain, Seni', 'Graphic Designer, UI/UX Designer', null],
            [14, 'Desain Produk', 'Merancang produk yang fungsional dan estetis.', 'Desain, Teknik', 'Product Designer', null],
            [15, 'Seni Rupa', 'Mengembangkan karya seni visual.', 'Seni', 'Seniman, Illustrator', null],
            [16, 'Teknik Mesin', 'Mempelajari mesin dan sistem mekanik.', 'Teknik, Otomotif', 'Mechanical Engineer', null],
            [17, 'Teknik Sipil', 'Mempelajari pembangunan infrastruktur.', 'Teknik', 'Civil Engineer', null],
            [18, 'Teknik Elektro', 'Mempelajari sistem kelistrikan dan elektronik.', 'Teknik', 'Electrical Engineer', null],
            [19, 'Teknik Otomotif', 'Fokus pada kendaraan dan sistem otomotif.', 'Otomotif, Teknik', 'Teknisi, Engineer Otomotif', null],
            [20, 'Pendidikan', 'Mempelajari metode pengajaran dan pendidikan.', 'Pendidikan', 'Guru, Dosen', null],
        ];

        foreach ($data as $item) {
            Jurusan::updateOrCreate(
                ['id_jurusan' => $item[0]],
                [
                    'nama_jurusan' => $item[1],
                    'deskripsi_singkat' => $item[2],
                    'kategori_relevan' => $item[3],
                    'prospek_karir' => $item[4],
                    'gambar_url' => $item[5],
                ]
            );
        }
    }
}