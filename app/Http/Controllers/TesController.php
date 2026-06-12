<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questions;
use App\Models\Hasil_Tes;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Auth;

class TesController extends Controller
{
    public function index()
    {
        $questions = Questions::orderBy('id_soal', 'asc')->get();
        return view('tes', compact('questions'));
    }

    public function proses(Request $request)
    {
        // 1. Validasi Input Jawaban
        $request->validate([
            'jawaban' => 'required|array',
        ]);

        $jawabanUser = $request->input('jawaban'); // [id_soal => skor_1_sampai_5]

        // 2. Inisialisasi Wadah Skor Rumpun (Berdasarkan seeder kategori_minat kamu)
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

        // Penampung nilai maksimum yang *mungkin* didapat per rumpun untuk pembagi persentase dinamis
        $skorMaksimalRumpun = $skorRumpun; 

        // 3. Kalkulasi Skor Pengguna & Skor Maksimal Terdistribusi
        $allQuestions = Questions::all()->keyBy('id_soal');

        foreach ($jawabanUser as $id_soal => $skor) {
            $soal = $allQuestions->get($id_soal);
            
            if ($soal && $soal->kategori_minat) {
                // Pecah string koma (ex: "IT, Kedokteran, Teknik") menjadi array bersih
                $listRumpunSoal = array_map('trim', explode(',', $soal->kategori_minat));

                foreach ($listRumpunSoal as $rumpun) {
                    if (array_key_exists($rumpun, $skorRumpun)) {
                        $skorRumpun[$rumpun] += (int)$skor;
                        $skorMaksimalRumpun[$rumpun] += 5; // Bobot nilai 5 jika user pilih 'Sangat Setuju'
                    }
                }
            }
        }

        // 4. Urutkan Rumpun untuk Mencari Minat Tertinggi User
        arsort($skorRumpun);
        $rumpunTertinggi = array_key_first($skorRumpun);
        $skorTertinggi = $skorRumpun[$rumpunTertinggi];

        // 5. ALGORITMA REKOMENDASI JURUSAN (Akurat Berdasarkan Bobot Kecocokan Terbanyak)
        $semuaJurusan = Jurusan::all();
        $jurusanTerpilih = null;
        $skorKecocokanFinal = 0;
        $bobotKecocokanMaksimal = -1;

        foreach ($semuaJurusan as $jurusan) {
            if ($jurusan->kategori_relevan) {
                // Pecah tag rumpun milik jurusan (ex: "IT, Bisnis" -> ['IT', 'Bisnis'])
                $rumpunJurusan = array_map('trim', explode(',', $jurusan->kategori_relevan));

                // Hitung berapa banyak rumpun jurusan yang diminati oleh user berdasarkan jawaban mereka
                $bobotMatchKeJurusan = 0;
                foreach ($rumpunJurusan as $rj) {
                    if (isset($skorRumpun[$rj])) {
                        $bobotMatchKeJurusan += $skorRumpun[$rj];
                    }
                }

                // Cari jurusan yang memiliki akumulasi nilai kecocokan tertinggi
                if ($bobotMatchKeJurusan > $bobotKecocokanMaksimal) {
                    $bobotKecocokanMaksimal = $bobotMatchKeJurusan;
                    $jurusanTerpilih = $jurusan;
                }
            }
        }

        // Fallback jika tidak ada data jurusan yang match sama sekali
        $idJurusanFinal = $jurusanTerpilih ? $jurusanTerpilih->id_jurusan : 1;

        // 6. Perhitungan Persentase Kelayakan Dinamis (Anti Bocor di atas 100%)
        $maksimalMungkinRumpun = $skorMaksimalRumpun[$rumpunTertinggi] ?? 5;
        $skorKecocokanFinal = ($skorTertinggi > 0) 
            ? min(round(($skorTertinggi / $maksimalMungkinRumpun) * 100), 100) 
            : 0;

        // 7. Simpan ke Database
        $hasil = Hasil_Tes::create([
            'id_user'        => Auth::id() ?? 1,
            'id_jurusan'     => $idJurusanFinal,
            'skor_kecocokan' => $skorKecocokanFinal,
            'tanggal_tes'    => now()
        ]);

        return redirect()->route('tes.hasil', ['id' => $hasil->id_hasil])
            ->with('success', 'Tes minat bakat berhasil dianalisis!');
    }

    public function tampilkanHasil($id)
    {
        $hasil = Hasil_Tes::with('jurusan')->findOrFail($id);

        // Menampilkan label grafik jaring laba-laba
        $labels = ['IT & Teknik', 'Psikologi & Sosial', 'Desain & Seni', 'Bisnis & Manajemen', 'Akuntansi & Admin'];
        
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