<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questions;

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
        // Validasi input jawaban yang masuk
        $request->validate([
            'jawaban' => 'required|array',
        ]);

        $jawabanUser = $request->input('jawaban');
        //dd($jawabanUser); // Debug: tampilkan jawaban yang diterima

        // LOGIKA PROSES JAWABAN ANDA DI SINI
        // Contoh: hitung skor, simpan ke tabel hasil_tes, dll.

        return redirect()->route('dashboard')->with('success', 'Tes berhasil diselesaikan!');
    }
}