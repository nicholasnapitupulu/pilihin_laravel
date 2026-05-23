<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Menambahkan semua kolom SELECT ke dalam GROUP BY agar lolos Strict Mode Laravel
        $top_kampus = DB::select("
            SELECT k.id_kampus, k.nama_kampus, k.lokasi, k.akreditasi, k.estimasi_biaya, k.logo_kampus,
                   COUNT(r.id_jurusan) as jumlah_prodi
            FROM kampus k
            LEFT JOIN relasi_kampus_jurusan r ON k.id_kampus = r.id_kampus
            GROUP BY k.id_kampus, k.nama_kampus, k.lokasi, k.akreditasi, k.estimasi_biaya, k.logo_kampus
            ORDER BY jumlah_prodi DESC, k.nama_kampus ASC
            LIMIT 5
        ");

        // Kirim data hasil query tadi ke file index.blade.php
        return view('index', compact('top_kampus'));
    }

    public function kampus()
    {
    // Mengambil semua data dari tabel kampus
    $all_kampus = \DB::select("SELECT * FROM kampus");

    // Kirim data ke view kampus.blade.php
    return view('kampus', compact('all_kampus'));
    }
}