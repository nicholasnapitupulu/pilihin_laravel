<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Superadmin Dashboard - PILIH.in</title>
    <link href="{{ asset('src/output.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-slate-50 flex min-h-screen">
    @include('components.sidebar_superadmin')

    <main class="flex-1 p-10">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-slate-800">Pusat Kendali Sistem</h1>
            <p class="text-sm text-slate-500 mt-1">Pantau statistik ekosistem PILIH.in</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <p class="text-xs font-bold text-slate-400 uppercase">Total Siswa</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $totalSiswa }} User</h3>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <p class="text-xs font-bold text-slate-400 uppercase">Total Tes</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $totalTes }} Kali</h3>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <p class="text-xs font-bold text-slate-400 uppercase">Status DB</p>
                <h3 class="text-lg font-bold text-emerald-600 mt-2">Terhubung</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <h2 class="text-lg font-extrabold text-slate-800 mb-4">Tren Registrasi Siswa</h2>
            <div class="relative w-full h-64">
                <canvas id="userGrowthChart"></canvas>
            </div>
        </div>
    </main>

    <script>
        const ctx = document.getElementById('userGrowthChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Siswa Baru',
                    data: {!! json_encode($chartData) !!},
                    backgroundColor: '#8b5cf6',
                    borderRadius: 8
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    </script>
</body>
</html>