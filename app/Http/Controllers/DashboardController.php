<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Hasil_Tes;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman Dashboard beserta Riwayat Tes dengan Pagination
     */
    public function index() {
        // Hanya ambil data user untuk dashboard profil
        return view('dashboard', [
            'nama_user' => auth()->user()->nama_lengkap,
            'email_user' => auth()->user()->email,
            'user_foto' => auth()->user()->foto_profil
        ]);
    }

    //Page Riwayat Tes
    public function riwayat() {
        $riwayat_result = Hasil_Tes::where('id_user', auth()->id())
            ->with('jurusan')
            ->latest()
            ->paginate(6);
            
        return view('riwayat', compact('riwayat_result'));
    }

    //fitur export pdf
    public function exportPdf()
    {
        $riwayat_result = Hasil_Tes::where('id_user', auth()->id())->with('jurusan')->get();
        $pdf = Pdf::loadView('riwayat_pdf', compact('riwayat_result'));
        return $pdf->download('riwayat-tes-pilih-in.pdf');
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