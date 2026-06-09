<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Rekomendasi - PILIH.in</title>
    <link href="{{ asset('src/output.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 flex flex-col min-h-screen">
    
    @include('components.navbar')

    <div class="container mx-auto px-4 py-8 max-w-5xl flex-grow">

        <div class="mt-10 mb-10 text-center">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight flex items-center justify-center gap-2">
                Hasil Tes Minatmu 🎯
            </h1>
            <p class="text-sm text-slate-400 mt-2">
                Dibuat pada: {{ \Carbon\Carbon::parse($hasil->tanggal_tes ?? now())->translatedFormat('d F Y H:i') }}
            </p>
        </div>
        
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="bg-slate-50/50 border border-slate-100 rounded-2xl p-6 flex flex-col justify-center items-center text-center">
                    <h3 class="text-slate-500 font-medium text-sm mb-4">Tingkat Kecocokan</h3>
                    
                    <div class="relative flex items-center justify-center w-36 h-36 rounded-full bg-white shadow-inner border border-slate-100">
                        <span class="text-4xl font-extrabold text-indigo-600">{{ $hasil->skor_kecocokan }}%</span>
                    </div>
                    
                    <p class="text-xs text-slate-400 mt-4 max-w-xs">
                        Berdasarkan akumulasi jawaban kuesioner minat bakat yang kamu isi.
                    </p>
                </div>

                <div class="bg-slate-50/50 border border-slate-100 rounded-2xl p-6 flex flex-col items-center justify-center">
                    <h3 class="text-slate-500 font-medium text-sm mb-4">Analisis Potensi Kategori</h3>
                    <div class="w-full max-w-[280px] h-[280px] flex items-center justify-center">
                        <canvas id="radarChart"></canvas>
                    </div>
                </div>

            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 mb-6 flex items-start space-x-4">
            <div class="p-3 bg-amber-50 rounded-xl text-amber-600 flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h4 class="text-sm font-medium text-slate-400">Rekomendasi Jurusan Utama</h4>
                <h2 class="text-2xl font-bold text-slate-800 mt-1">{{ $hasil->jurusan->nama_jurusan ?? 'Belum Diketahui' }}</h2>
                <p class="text-slate-500 text-sm mt-2">
                    <span class="font-semibold text-slate-600">Prospek Karir:</span> {{ $hasil->jurusan->prospek_karir ?? '-' }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            
            <a href="{{ url('/jurusan/' . $hasil->id_jurusan . '/roadmap') }}" class="group bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:border-indigo-200 hover:shadow-md transition-all duration-300 flex items-center space-x-4">
                <div class="p-4 bg-indigo-50 text-indigo-600 rounded-2xl group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">Roadmap Lengkap</h3>
                    <p class="text-xs text-slate-400 mt-1">Panduan kompetensi dan mata kuliah tiap semester.</p>
                </div>
            </a>

            <a href="{{ url('/kampus?jurusan=' . $hasil->id_jurusan) }}" class="group bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:border-emerald-200 hover:shadow-md transition-all duration-300 flex items-center space-x-4">
                <div class="p-4 bg-emerald-50 text-emerald-600 rounded-2xl group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 group-hover:text-emerald-600 transition-colors">Saran Kampus Terbaik</h3>
                    <p class="text-xs text-slate-400 mt-1">Rekomendasi kampus terkurasi penyedia jurusan ini.</p>
                </div>
            </a>

        </div>

        <div class="flex justify-center mb-4">
            <a href="{{ route('dashboard') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-xl transition text-sm shadow-sm">
                Kembali ke Dashboard
            </a>
        </div>

    </div>

    @include('components.footer')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('radarChart').getContext('2d');
            new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [{
                        label: 'Skor Minat',
                        data: {!! json_encode($dataSkor) !!},
                        backgroundColor: 'rgba(99, 102, 241, 0.2)',
                        borderColor: 'rgba(99, 102, 241, 1)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgba(99, 102, 241, 1)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgba(99, 102, 241, 1)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        r: {
                            angleLines: { display: true },
                            suggestedMin: 0,
                            suggestedMax: 100,
                            ticks: { display: false }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        });
    </script>
</body>
</html>