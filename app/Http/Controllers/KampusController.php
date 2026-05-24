<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kampus; // Pastikan untuk memanggil (import) Model Kampus

class KampusController extends Controller
{
    public function index()
    {
        // Mengambil semua data kampus beserta relasi jurusannya
        // Jika kamu hanya butuh data kampus saja (sesuai blade kamu saat ini), 
        // cukup gunakan Kampus::all();
        $all_kampus = Kampus::with('jurusan')->get(); 

        // Mengirim variabel $all_kampus ke view 'kampus.blade.php'
        return view('kampus', compact('all_kampus'));
    }
}