<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Kampus;

class AdminController extends Controller
{
    public function index()
    {
        // Mengambil statistik data dengan aggregate count()
        $count_users = User::where('role', 'user')->count();
        $count_majors = Jurusan::count();
        $count_campuses = Kampus::count();

        return view('admin.dashboard', compact('count_users', 'count_majors', 'count_campuses'));
    }
}