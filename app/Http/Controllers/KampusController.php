<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kampus; // Pastikan untuk memanggil (import) Model Kampus
use Barryvdh\DomPDF\Facade\Pdf;

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
        $campuses = Kampus::orderBy('id_kampus', 'asc')->get();
        return view('admin.kampus', compact('campuses'));
    }

    // Tambah Data
    public function store(Request $request)
        {
            // 1. Validasi Input Data beserta File Gambarnya
            $request->validate([
                'nama_kampus'    => 'required|string|max:255',
                'lokasi'         => 'required|string|max:255',
                'akreditasi'     => 'required|string',
                'estimasi_biaya' => 'required|string',
                'gambar'         => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maks 2MB
            ]);

            // Variabel awal jika gambar tidak wajib (nullable) atau sebagai cadangan
            $pathGambar = null;

            // 2. Proses Upload Gambar ke folder public/img
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $fileName = 'kampus_' . time() . '.' . $file->getClientOriginalExtension();
                
                // File tetap pindah ke folder public/img
                $file->move(public_path('img'), $fileName);
                
                // DATABASE HANYA MENYIMPAN NAMA FILE SAJA
                $pathGambar = $fileName; 
            }

            // 3. Simpan Data ke Database sesuai kolom `logo_kampus`
            Kampus::create([
                'nama_kampus'    => $request->nama_kampus,
                'lokasi'         => $request->lokasi,
                'akreditasi'     => $request->akreditasi,
                'estimasi_biaya' => $request->estimasi_biaya,
                'logo_kampus'    => $pathGambar, // DISESUAIKAN menjadi logo_kampus
            ]);

            return redirect()->route('kampus.admin_index')->with('success', 'Kampus baru berhasil ditambahkan beserta foto!');
        }

    // Hapus Data
    public function destroy($id)
    {
        $kampus = Kampus::findOrFail($id);
        $kampus->delete();
        return redirect()->route('kampus.admin_index')->with('success', 'Kampus berhasil dihapus!');
    }

    // Export PDF
    public function exportPdf()
    {
        // Ambil semua data kampus dari database
        $campuses = Kampus::all();

        // Load view khusus cetak pdf dan kirimkan data kampus
        $pdf = Pdf::loadView('admin.kampus_pdf', compact('campuses'));
        
        // Mengatur kertas menjadi A4 Potrait
        $pdf->setPaper('a4', 'portrait');

        // Download otomatis file PDF-nya (Sintaks string sudah diperbaiki rapi)
        return $pdf->download('laporan-data-kampus-'.date('Y-m-d').'.pdf');
    }
}