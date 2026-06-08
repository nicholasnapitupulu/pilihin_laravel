<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $nama_user = $user->nama_lengkap;
        $email_user = $user->email;

        $riwayat_result = [];

        return view('dashboard', compact('nama_user', 'email_user', 'riwayat_result'));
    }
}