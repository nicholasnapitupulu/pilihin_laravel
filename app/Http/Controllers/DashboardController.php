<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Hasil_Tes; // Pastikan namespace Model Hasil_Tes sudah benar

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman Dashboard beserta Riwayat Tes
     */
    public function index()
    {
        $user = Auth::user();

        $nama_user = $user->nama_lengkap;
        $email_user = $user->email;
        $user_foto = $user->foto_profil; // Mengambil path foto dari DB

        // Mengambil riwayat tes user yang sedang login beserta relasi jurusannya
        // Menggunakan primary key 'id_user' sesuai konfigurasi tabel kamu
        $riwayat_result = Hasil_Tes::where('id_user', $user->id_user)
                            ->with('jurusan') 
                            ->orderBy('tanggal_tes', 'desc')
                            ->get();

        return view('dashboard', compact('nama_user', 'email_user', 'user_foto', 'riwayat_result'));
    }

    /**
     * Mengamankan dan memproses upload foto profil baru
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');

            // Membuat nama unik untuk file (contoh: foto_1_1712345678.jpg)
            $nama_file = 'foto_' . $user->id_user . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Tentukan jalur tujuan langsung ke folder public/foto_user
            $tujuan_upload = public_path('user_foto');

            // Hapus file foto profil lama di folder public jika ada dan bukan bawaan default
            if ($user->foto_profil && file_exists($tujuan_upload . '/' . $user->foto_profil)) {
                @unlink($tujuan_upload . '/' . $user->foto_profil);
            }

            // Pindahkan file baru ke direktori public/foto_user
            $file->move($tujuan_upload, $nama_file);

            // Simpan HANYA nama filenya saja ke database
            $user->update([
                'foto_profil' => $nama_file
            ]);

            return redirect()->route('dashboard')->with('success', 'Foto profil berhasil diperbarui!');
        }

        return redirect()->route('dashboard')->with('error', 'Gagal mengganti foto.');
    }
}