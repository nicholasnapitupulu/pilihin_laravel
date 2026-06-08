<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman Login & Register (Single Page Form)
    public function showAuthPage(Request $request)
    {
        // Menyimpan parameter redirect jika ada (bawaan Laravel biasanya menggunakan intended())
        $redirect = $request->query('redirect', 'dashboard');
        return view('login', compact('redirect'));
    }

    // Memproses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email tidak boleh kosong!',
            'email.email' => 'Format email tidak valid!',
            'password.required' => 'Password tidak boleh kosong!',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'user') {
                return redirect()->intended($request->input('redirect', 'dashboard'));
            } else if ($user->role === 'admin') {
                return redirect()->to('/admin/dashboard');
            }
        }

        return redirect()->back()
            ->withInput($request->only('email'))
            ->with('error', 'Email atau password yang Anda masukkan salah.');
    }

    // Memproses Registrasi Akun Baru
    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:8',
            'asal_sekolah' => 'required|string|max:100',
        ], [
            'nama_lengkap.required' => 'Nama lengkap tidak boleh kosong!',
            'email.required' => 'Email tidak boleh kosong!',
            'email.unique' => 'Email sudah terdaftar!',
            'password.required' => 'Password tidak boleh kosong!',
            'password.min' => 'Password minimal harus 8 karakter!',
            'asal_sekolah.required' => 'Asal sekolah tidak boleh kosong!',
        ]);

        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'asal_sekolah' => $request->asal_sekolah,
            'role' => 'user', // Default role sesuai struktur database
        ]);

        // Otomatis login setelah berhasil mendaftar
        Auth::login($user);

        return redirect()->to($request->input('redirect', 'dashboard'));
    }

    // Memproses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}