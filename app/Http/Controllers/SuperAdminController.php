<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Pastikan untuk memanggil (import) Model User

class SuperAdminController extends Controller
{
    public function index()
    {
        $users = User::where('role', '=', 'admin')->get();
        return view('superadmin.dashboard', compact('users'));
    }

    public function store(Request $request)
    {
        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => $request->password,
            'asal_sekolah' => '',
            'role' => 'admin',
        ]);

        return redirect()->route('superadmin.dashboard');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('superadmin.dashboard');
    }
}