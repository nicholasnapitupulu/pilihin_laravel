<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan; // Memanggil Model Jurusan

class JurusanController extends Controller
{
    public function index()
    {
        // Mengambil semua data dari tabel jurusan
        $all_jurusan = Jurusan::all(); 

        // Mengirim data ke view 'jurusan.blade.php'
        return view('jurusan', compact('all_jurusan'));
    }

    public function roadmap($id)
    {
        // Cari jurusan berdasarkan ID, dan sekalian tarik data roadmap-nya
        $jurusan = Jurusan::with('roadmap')->where('id_jurusan', $id)->firstOrFail();
        
        // Kirim data ke view roadmap.blade.php (yang akan kita buat nanti)
        return view('roadmap', compact('jurusan'));
    }
}