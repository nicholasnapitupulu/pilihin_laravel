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
     */
    public function index()
    {
        // Mengambil statistik user per bulan dengan cara yang aman untuk MySQL & SQLite
        $usersPerMonth = User::where('role', 'user')
            ->select(DB::raw("COUNT(id_user) as count"), DB::raw("strftime('%m', created_at) as month_num"))
            ->whereYear('created_at', 2026)
            ->groupBy('month_num')
            ->orderBy('month_num')
            ->get();

        $monthNames = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', 
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', 
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];

        $chartLabels = [];
        $chartData = [];

        foreach ($usersPerMonth as $data) {
            $chartLabels[] = $monthNames[$data->month_num] ?? 'Bulan ' . $data->month_num;
            $chartData[] = (int) $data->count;
        }

        if (empty($chartLabels)) {
            $chartLabels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'];
            $chartData = [0, 0, 0, 0, 0, 0];
        }

        $totalTes = DB::table('hasil_tes')->count(); 
        $totalSiswa = User::where('role', 'user')->count();

        $ringkasanLogs = Schema::hasTable('log_aktivitas') 
            ? DB::table('log_aktivitas')->orderBy('created_at', 'desc')->limit(5)->get() 
            : collect([]);

        return view('superadmin.dashboard', compact(
            'chartLabels', 'chartData', 'totalTes', 'totalSiswa', 'ringkasanLogs'
        ));
    }

    /**
     * 2. HALAMAN KELOLA ADMIN
     */
    public function adminIndex()
    {
        $users = User::where('role', 'admin')->orderBy('id_user', 'desc')->get();
        return view('superadmin.kelola_admin', compact('users'));
    }

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

        return redirect()->route('superadmin.admin.index')->with('success', 'Akun Admin baru berhasil didaftarkan!');
    }

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
        return redirect()->route('superadmin.admin.index')->with('success', 'Data akun admin berhasil diperbarui!');
    }

    public function toggleStatus($id)
    {
        $user = User::where('id_user', $id)->firstOrFail();
        $user->status = ($user->status === 'aktif') ? 'nonaktif' : 'aktif';
        $user->save();
        return redirect()->route('superadmin.admin.index')->with('success', 'Status operasional akun admin berhasil diubah!');
    }

    public function destroy($id)
    {
        $user = User::where('id_user', $id)->firstOrFail();
        $user->delete();
        return redirect()->route('superadmin.admin.index')->with('success', 'Akun Admin telah berhasil dihapus!');
    }

    /**
     * 3. HALAMAN KELOLA SISWA
     */
    public function userIndex()
    {
        $users = User::where('role', 'user')->orderBy('id_user', 'desc')->get();
        return view('superadmin.kelola_user', compact('users'));
    }

    public function destroyUser($id)
    {
        $user = User::where('id_user', $id)->firstOrFail();
        $user->delete();
        return redirect()->route('superadmin.users.index')->with('success', 'Akun Siswa berhasil dihapus!');
    }
}