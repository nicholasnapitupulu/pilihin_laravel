<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PILIH.in</title>
    <link href="{{ asset('src/output.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-slate-50 font-sans text-slate-800">

    @include('components.navbar')

    <main class="pt-32 pb-20 container mx-auto px-4">

        <section class="max-w-4xl mx-auto space-y-5">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-3xl font-extrabold text-slate-800">Riwayat Rekomendasimu</h3>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('riwayat.export') }}" 
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 hover:bg-slate-200 rounded-xl font-bold text-sm shadow-sm transition-all duration-200 transform hover:-translate-y-0.5 active:scale-95 focus:outline-none focus:ring-2 focus:ring-slate-300">
                <span class="text-base select-none" style="color: #dc2626;">📄</span> 
                <span class="text-slate-700">Export PDF</span>
            </a>
        </div>
    </div> @if(isset($riwayat_result) && count($riwayat_result) > 0)
        <div class="grid gap-5">
            @foreach($riwayat_result as $riwayat)
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-all duration-300 hover:shadow-md">
                    <div class="flex items-center gap-6 text-left">
                        <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 font-extrabold text-xl flex-shrink-0 shadow-inner">
                            {{ $riwayat->skor_kecocokan }}%
                        </div>
                        <div class="space-y-1">
                            <span class="text-xs text-indigo-500 font-semibold uppercase tracking-wider block">
                                {{ \Carbon\Carbon::parse($riwayat->tanggal_tes)->translatedFormat('d F Y') }}
                            </span>
                            <h4 class="text-xl font-bold text-slate-800 tracking-tight leading-snug">
                                {{ $riwayat->jurusan->nama_jurusan ?? 'Jurusan Pilihan' }}
                            </h4>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-end flex-shrink-0">
                        <a href="{{ url('/tes/hasil/' . $riwayat->id_hasil) }}" class="px-6 py-3 bg-slate-50 border border-slate-200 text-slate-700 font-bold text-xs rounded-xl hover:bg-slate-100">
                            Detail Hasil
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $riwayat_result->links('pagination::tailwind') }}
        </div>
    @else
        <div class="bg-white rounded-3xl p-12 border border-dashed border-slate-200 text-center text-slate-400">
            <p>Belum ada riwayat pengerjaan tes.</p>
        </div>
    @endif

</section>

    </main>

    @include('components.footer')

</body>

</html>