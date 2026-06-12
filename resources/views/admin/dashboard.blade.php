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
        
        @include('components.sidebar_admin')

        <main class="flex-1 p-10">
            <h1 class="text-3xl font-extrabold text-slate-800 mb-8">Ringkasan Sistem</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                    <p class="text-slate-500 text-sm font-bold uppercase tracking-wider">Total User</p>
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