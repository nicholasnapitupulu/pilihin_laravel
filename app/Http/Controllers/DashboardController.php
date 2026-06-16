<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Hasil_Tes; 

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman Dashboard beserta Riwayat Tes dengan Pagination
     */
    public function index()
{
    $user = Auth::user();
    $nama_user = $user->nama_lengkap;
    $email_user = $user->email;
    $user_foto = $user->foto_profil;

    // Di DashboardController.php
$riwayat_result = Hasil_Tes::where('id_user', $user->id_user)
                        ->with('jurusan')
                        ->orderBy('tanggal_tes', 'desc')
                        ->paginate(5); // Angka 5 adalah jumlah data per halaman

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

            $nama_file = 'foto_' . $user->id_user . '_' . time() . '.' . $file->getClientOriginalExtension();

            $tujuan_upload = public_path('user_foto');

            if ($user->foto_profil && file_exists($tujuan_upload . '/' . $user->foto_profil)) {
                @unlink($tujuan_upload . '/' . $user->foto_profil);
            }

            $file->move($tujuan_upload, $nama_file);

            $user->update([
                'foto_profil' => $nama_file
            ]);

            return redirect()->route('dashboard')->with('success', 'Foto profil berhasil diperbarui!');
        }

        return redirect()->route('dashboard')->with('error', 'Gagal mengganti foto.');
    }
}