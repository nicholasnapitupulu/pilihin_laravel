<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan; // Memanggil Model Jurusan

class JurusanController extends Controller
{
    public function index()
    {
        // Mengambil semua data dari tabel jurusan
        $all_jurusan = Jurusan::orderBy('nama_jurusan', 'asc')->paginate(6); // Menampilkan 6 jurusan per halaman, diurutkan berdasarkan nama jurusan
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

    public function admin_index()
    {
        // Mengambil data diurutkan dari yang terbaru (seperti ORDER BY id_jurusan DESC)
        $majors = Jurusan::orderBy('id_jurusan', 'desc')->get();
        
        return view('admin.jurusan', compact('majors'));
    }

    // Proses Tambah Jurusan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'kategori_relevan' => 'required|string|max:255',
            'deskripsi_singkat' => 'required|string',
        ]);

        Jurusan::create($validated);

        return redirect()->route('jurusan.admin_index')->with('success', 'Jurusan berhasil ditambahkan!');
    }

    // Proses Hapus Jurusan
    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();

        return redirect()->route('jurusan.admin_index')->with('success', 'Jurusan berhasil dihapus!');
    }
}