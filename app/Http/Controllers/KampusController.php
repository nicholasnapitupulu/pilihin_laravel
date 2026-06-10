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

    public function admin_index()
    {
        $campuses = Kampus::orderBy('id_kampus', 'desc')->get();
        return view('admin.kampus', compact('campuses'));
    }

    // Tambah Data
    public function store(Request $request)
    {
        $request->validate([
            'nama_kampus' => 'required',
            'lokasi' => 'required',
            'akreditasi' => 'required',
            'estimasi_biaya' => 'required',
        ]);

        Kampus::create([
            'nama_kampus' => $request->nama_kampus,
            'lokasi' => $request->lokasi,
            'akreditasi' => $request->akreditasi,
            'estimasi_biaya' => $request->estimasi_biaya,
        ]);

        return redirect()->route('kampus.admin_index')->with('success', 'Kampus berhasil ditambahkan!');
    }

    // Hapus Data
    public function destroy($id)
    {
        $kampus = Kampus::findOrFail($id);
        $kampus->delete();
        return redirect()->route('kampus.admin_index')->with('success', 'Kampus berhasil dihapus!');
    }
}