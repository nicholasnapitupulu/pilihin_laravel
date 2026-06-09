<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questions;
use App\Models\Hasil_Tes; // Menggunakan snake_case sesuai nama Model di seeder-mu
use App\Models\Jurusan;
use Illuminate\Support\Facades\Auth;

class TesController extends Controller
{
    public function index()
    {
        // Mengambil semua data soal diurutkan berdasarkan id_soal
        $questions = Questions::orderBy('id_soal', 'asc')->get();

        return view('tes', compact('questions'));
    }

    public function proses(Request $request)
    {
        // 1. Validasi input jawaban yang masuk
        $request->validate([
            'jawaban' => 'required|array',
        ]);

        $jawabanUser = $request->input('jawaban'); // Format: [id_soal => skor_1_sampai_5]

        // 2. Inisialisasi penampung skor untuk setiap kata kunci kelompok minat
        // Kita petakan rumpun string dari seeder: 'IT', 'Kedokteran', 'Teknik', 'Psikologi', dll.
        $skorRumpun = [
            'IT'           => 0,
            'Kedokteran'   => 0,
            'Teknik'       => 0,
            'Psikologi'    => 0,
            'Pendidikan'   => 0,
            'Desain'       => 0,
            'Seni'         => 0,
            'Manajemen'    => 0,
            'Bisnis'       => 0,
            'Akuntansi'    => 0,
            'Administrasi' => 0,
            'Otomotif'     => 0,
        ];

        // 3. Hitung akumulasi skor user berdasarkan string kategori_minat di soal
        foreach ($jawabanUser as $id_soal => $skor) {
            $soal = Questions::find($id_soal);
            
            if ($soal) {
                // Contoh isi kolom: "IT, Kedokteran, Teknik"
                $kategoriTeks = $soal->kategori_minat; 
                
                // Pecah string berdasarkan koma menjadi array, lalu bersihkan spasi kosongnya
                $listRumpunSoal = array_map('trim', explode(',', $kategoriTeks));

                foreach ($listRumpunSoal as $rumpun) {
                    if (array_key_exists($rumpun, $skorRumpun)) {
                        $skorRumpun[$rumpun] += (int)$skor;
                    }
                }
            }
        }

        // 4. Cari rumpun dengan nilai tertinggi
        arsort($skorRumpun); 
        $rumpunTertinggi = array_key_first($skorRumpun);
        $skorTertinggi = $skorRumpun[$rumpunTertinggi];

        // 5. Cari id_jurusan yang cocok di database berdasarkan rumpun tertinggi tersebut
        // Kita cari nama jurusan yang mirip atau mengandung kata kunci rumpun tertinggi
        $jurusanCocok = Jurusan::where('nama_jurusan', 'LIKE', '%' . $rumpunTertinggi . '%')->first();
        
        // Jika tidak ketemu di database, berikan fallback/default ke id_jurusan 1 atau 10
        $idJurusanTerpilih = $jurusanCocok ? $jurusanCocok->id_jurusan : 1; 

        // Hitung persentase skor_kecocokan (Skor didapat dibandingkan terhadap nilai ideal maksimum, misal 80%)
        // Kamu bisa sesuaikan rumusnya. Di sini kita buat rentang persentase dinamis maksimal 100
        $skorMaksimalEstimasi = 25; // Asumsi bobot sebaran soal
        $persentaseKecocokan = min(round(($skorTertinggi / $skorMaksimalEstimasi) * 100), 100);

        // 6. Simpan ke database sesuai struktur kolom Hasil_TesSeeder
        $hasil = Hasil_Tes::create([
            'id_user' => Auth::id() ?? 1, // Jika belum login, fallback ke id_user 1 untuk testing
            'id_jurusan' => $idJurusanTerpilih,
            'skor_kecocokan' => $persentaseKecocokan,
            'tanggal_tes' => now()
        ]);

        // 7. Alihkan halaman ke view hasil dengan membawa id_hasil yang baru dibuat
        return redirect()->route('tes.hasil', ['id' => $hasil->id_hasil])->with('success', 'Tes berhasil diselesaikan!');
    }

    public function tampilkanHasil($id)
    {
        // Mengambil data hasil beserta relasi model jurusannya
        $hasil = Hasil_Tes::with('jurusan')->findOrFail($id);

        // Siasati data untuk Radar Chart.js agar menampilkan rumpun utama dari seeder kuesioner kamu
        // Kita ambil beberapa sampel rumpun utama sebagai label grafik jaring laba-laba
        $labels = ['IT & Teknik', 'Psikologi & Sosial', 'Desain & Seni', 'Bisnis & Manajemen', 'Akuntansi & Admin'];
        
        // Contoh kalkulasi visualisasi dummy berbasis skor_kecocokan agar grafik tetap terisi proporsional
        $base = $hasil->skor_kecocokan;
        $dataSkor = [
            $base, 
            max($base - 20, 30), 
            max($base - 40, 15), 
            max($base - 10, 45), 
            max($base - 30, 25)
        ];

        return view('hasil', compact('hasil', 'labels', 'dataSkor'));
    }
}