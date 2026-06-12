<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan; // Memanggil Model Jurusan
use App\Models\Kampus; // Jika butuh relasi nama kampus
use Barryvdh\DomPDF\Facade\Pdf;

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
        $majors = Jurusan::orderBy('id_jurusan', 'asc')->get();
        
        return view('admin.jurusan', compact('majors'));
    }

    // Proses Tambah Jurusan
    public function store(Request $request)
    {
        // 1. Validasi input data dari form (termasuk prospek_karir)
        $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'kategori_relevan' => 'required|string|max:255',
            'deskripsi_singkat' => 'required|string',
            'prospek_karir' => 'required|string', // Validasi tambahan
        ]);

        // 2. Simpan ke database menggunakan Model Jurusan
        Jurusan::create([
            'nama_jurusan' => $request->nama_jurusan,
            'kategori_relevan' => $request->kategori_relevan,
            'deskripsi_singkat' => $request->deskripsi_singkat,
            'prospek_karir' => $request->prospek_karir, // Menyimpan kolom prospek karir
        ]);

        // 3. Redirect kembali dengan pesan sukses
        return redirect()->route('jurusan.admin_index')->with('success', 'Jurusan baru berhasil ditambahkan!');
    }

    // Proses Hapus Jurusan
    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();

        return redirect()->route('jurusan.admin_index')->with('success', 'Jurusan berhasil dihapus!');
    }

    // Proses Update / Edit Jurusan
    public function update(Request $request, $id)
    {
        // 1. Validasi input data
        $request->validate([
            'nama_jurusan'      => 'required|string|max:255',
            'kategori_relevan'  => 'required|string|max:255',
            'deskripsi_singkat' => 'required|string',
            'prospek_karir'     => 'required|string',
        ]);

        // 2. Cari data berdasarkan ID dan update
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->update([
            'nama_jurusan'      => $request->nama_jurusan,
            'kategori_relevan'  => $request->kategori_relevan,
            'deskripsi_singkat' => $request->deskripsi_singkat,
            'prospek_karir'     => $request->prospek_karir,
        ]);

        // 3. Kembali dengan pesan sukses
        return redirect()->route('jurusan.admin_index')->with('success', 'Data jurusan berhasil diperbarui!');
    }

    public function exportPdf()
    {
        // Mengambil semua data dari tabel jurusan secara berurutan
        $majors = Jurusan::orderBy('id_jurusan', 'asc')->get();

        // Load view khusus cetak PDF jurusan dan kirimkan datanya
        $pdf = Pdf::loadView('admin.jurusan_pdf', compact('majors'));

        // Mengatur kertas menjadi A4 Potrait
        $pdf->setPaper('a4', 'portrait');

        // Download otomatis file PDF dengan nama dinamis sesuai tanggal hari ini
        return $pdf->download('laporan-data-jurusan-' . date('Y-m-d') . '.pdf');
    }
}