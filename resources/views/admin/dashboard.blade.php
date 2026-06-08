<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - PILIH.in</title>
    <link href="{{ asset('src/output.css') }}" rel="stylesheet">
</head>
<body class="bg-slate-50 font-sans">
    <div class="flex min-h-screen">
        
        <aside class="w-64 bg-slate-900 text-white p-6">
            <h2 class="text-2xl font-bold mb-8">PILIH.in <span class="text-purple-400 text-sm">Admin</span></h2>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg bg-slate-700 text-purple-400 font-bold">
                    Dashboard
                </a>
                <a href="" class="block px-3 py-2 rounded-lg hover:bg-slate-700 hover:text-purple-400 transition">
                    Kelola Jurusan
                </a>
                <a href="" class="block px-3 py-2 rounded-lg hover:bg-slate-700 hover:text-purple-400 transition">
                    Kelola Kampus
                </a>
                <a href="" class="block px-3 py-2 rounded-lg hover:bg-slate-700 hover:text-purple-400 transition">
                    📌 Prodi per Kampus
                </a>
                
                <hr class="border-slate-700 my-2">
                
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin keluar dari panel admin?')">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-red-400 hover:bg-slate-700 transition">
                        Logout
                    </button>
                </form>
            </nav>
        </aside>

        <main class="flex-1 p-10">
            <h1 class="text-3xl font-extrabold text-slate-800 mb-8">Ringkasan Sistem</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                    <p class="text-slate-500 text-sm font-bold uppercase tracking-wider">Total Siswa</p>
                    <h3 class="text-4xl font-black mt-2 text-slate-900">{{ $count_users }}</h3>
                </div>
                
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                    <p class="text-slate-500 text-sm font-bold uppercase tracking-wider">Data Jurusan</p>
                    <h3 class="text-4xl font-black mt-2 text-purple-600">{{ $count_majors }}</h3>
                </div>
                
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                    <p class="text-slate-500 text-sm font-bold uppercase tracking-wider">Data Kampus</p>
                    <h3 class="text-4xl font-black mt-2 text-indigo-600">{{ $count_campuses }}</h3>
                </div>
            </div>
        </main>

    </div>
</body>
</html>