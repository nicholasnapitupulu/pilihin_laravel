<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SuperAdminController extends Controller
{
    /**
     * 1. HALAMAN DASHBOARD (Grafik & Statistik)
     * Menampilkan metrik data kuantitas dan chart perkembangan sistem.
     */
    public function index()
    {
        // Hitung registrasi user baru (role: 'user') per bulan di tahun 2026 untuk grafik
        $usersPerMonth = User::where('role', '=', 'user')
            ->select(DB::raw("COUNT(id_user) as count"), DB::raw("MONTHNAME(created_at) as month"))
            ->whereYear('created_at', 2026)
            ->groupBy(DB::raw("MONTH(created_at)"), DB::raw("MONTHNAME(created_at)"))
            ->orderBy(DB::raw("MONTH(created_at)"))
            ->get();

        $chartLabels = $usersPerMonth->pluck('month')->toArray();
        $chartData = $usersPerMonth->pluck('count')->toArray();

        // Default value jika data bulan masih kosong agar grafik tidak blank
        if (empty($chartLabels)) {
            $chartLabels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'];
            $chartData = [0, 0, 0, 0, 0, 0];
        }

        // Ambil total baris pengerjaan tes dari tabel hasil_tes
        $totalTes = DB::table('hasil_tes')->count(); 
        
        // Ambil total user biasa (siswa) terdaftar global
        $totalSiswa = User::where('role', '=', 'user')->count();

        // Mengambil data log aktivitas (Aman dari crash jika tabel belum di-migrate)
        $ringkasanLogs = Schema::hasTable('log_aktivitas') 
            ? DB::table('log_aktivitas')->orderBy('created_at', 'desc')->limit(5)->get() 
            : collect([]);

        // Kirim data khusus untuk keperluan dashboard statistik saja
        return view('superadmin.dashboard', compact(
            'chartLabels', 
            'chartData', 
            'totalTes', 
            'totalSiswa', 
            'ringkasanLogs'
        ));
    }

    /**
     * 2. HALAMAN KELOLA ADMIN (Tabel & Manajemen CRUD)
     * Menampilkan tabel daftar admin operasional dan menangani aksi modal.
     */
    public function adminIndex()
    {
        // Mengambil semua data dengan role admin untuk dimasukkan ke tabel kelola admin
        $users = User::where('role', '=', 'admin')->orderBy('id_user', 'desc')->get();

        return view('superadmin.kelola_admin', compact('users'));
    }

    /**
     * PROSES SIMPAN ADMIN BARU
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'asal_sekolah' => 'PILIH.in Internal',
            'role' => 'admin',
            'status' => 'aktif', 
        ]);

        // Dialihkan kembali ke halaman Kelola Admin setelah menyimpan data
        return redirect()->route('superadmin.admin.index')->with('success', 'Akun Admin baru berhasil didaftarkan!');
    }

    /**
     * PROSES UPDATE DATA ADMIN
     */
    public function update(Request $request, $id)
    {
        $user = User::where('id_user', $id)->firstOrFail();

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' . $id . ',id_user',
            'password' => 'nullable|string|min:6',
        ]);

        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        
        // Dialihkan kembali ke halaman Kelola Admin setelah update data
        return redirect()->route('superadmin.admin.index')->with('success', 'Data akun admin berhasil diperbarui!');
    }

    /**
     * PROSES TURN ON/OFF OPERASIONAL ADMIN
     */
    public function toggleStatus($id)
    {
        $user = User::where('id_user', $id)->firstOrFail();
        $user->status = ($user->status === 'aktif') ? 'nonaktif' : 'aktif';
        $user->save();

        // Dialihkan kembali ke halaman Kelola Admin setelah mengubah status
        return redirect()->route('superadmin.admin.index')->with('success', 'Status operasional akun admin berhasil diubah!');
    }

    /**
     * PROSES HAPUS AKUN ADMIN
     */
    public function destroy($id)
    {
        $user = User::where('id_user', $id)->firstOrFail();
        $user->delete();
        
        // Dialihkan kembali ke halaman Kelola Admin setelah menghapus data
        return redirect()->route('superadmin.admin.index')->with('success', 'Akun Admin telah berhasil dihapus!');
    }

    /**
     * HALAMAN KELOLA SISWA
     */
    public function userIndex()
{
    // Mengambil semua user dengan role 'user' (siswa)
    $users = User::where('role', 'user')->orderBy('id_user', 'desc')->get();
    
    // UBAH DARI 'superadmin.users.index' MENJADI 'superadmin.kelola_user'
    return view('superadmin.kelola_user', compact('users'));
}

    /**
     * HAPUS AKUN SISWA
     */
    public function destroyUser($id)
    {
        $user = User::where('id_user', $id)->firstOrFail();
        $user->delete();
        
        return redirect()->route('superadmin.users.index')->with('success', 'Akun Siswa berhasil dihapus!');
    }

}