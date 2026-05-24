<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roadmap Karir - {{ $jurusan->nama_jurusan }} | PILIH.in</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-800">

    {{-- Navbar (Bisa disesuaikan jika kamu pakai layout terpisah) --}}
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-2">
                    <span class="text-2xl font-extrabold text-purple-600">✨ PILIH.in</span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="{{ url('/kampus') }}" class="text-slate-500 hover:text-slate-900 text-sm font-medium">Kampus</a>
                    <a href="{{ url('/jurusan') }}" class="text-slate-900 hover:text-slate-900 text-sm font-medium">Jurusan</a>
                    <a href="#" class="text-slate-500 hover:text-slate-900 text-sm font-medium">Tes Minat</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ url('/jurusan') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900">Kembali</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 py-12">
        {{-- Bagian Header Judul Jurusan --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-16 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 flex items-center gap-3">
                    📚 {{ $jurusan->nama_jurusan }}
                </h1>
                <p class="text-slate-500 mt-2 text-sm md:text-base">{{ $jurusan->deskripsi_singkat }}</p>
            </div>
            <a href="{{ url('/jurusan') }}" class="px-5 py-2.5 bg-slate-100 text-slate-700 rounded-xl text-sm font-semibold hover:bg-slate-200 transition shrink-0">
                Katalog Lainnya
            </a>
        </div>

        {{-- Bagian Timeline Roadmap --}}
        <div class="relative wrap overflow-hidden p-4 md:p-10 h-full">
            {{-- Garis vertikal di tengah --}}
            <div class="hidden md:block absolute border-opacity-20 border-slate-400 h-full border-l-4" style="left: 50%; transform: translateX(-50%);"></div>

            @forelse($jurusan->roadmap as $r)
                @php
                    // Menentukan apakah ganjil atau genap untuk posisi Kiri/Kanan
                    $isEven = $loop->iteration % 2 == 0;
                    // Menghitung tahun dan tipe semester
                    $tahun = ceil($r->semester / 2);
                    $tipeSemester = $r->semester % 2 != 0 ? 'Ganjil' : 'Genap';
                @endphp

                <div class="mb-8 flex justify-between items-center w-full {{ $isEven ? 'flex-row' : 'md:flex-row-reverse flex-row' }}">
                    <div class="hidden md:block w-5/12"></div>
                    
                    {{-- Bulatan Marker di Garis Tengah --}}
                    <div class="hidden md:flex z-20 items-center justify-center bg-white w-6 h-6 rounded-full border-4 border-slate-800 shadow-sm shrink-0"></div>
                    
                    {{-- Kotak Konten Card --}}
                    <div class="w-full md:w-5/12 bg-white border border-slate-100 rounded-2xl shadow-sm p-6 hover:shadow-md transition">
                        
                        {{-- Header Card (Semester & Tahun) --}}
                        <div class="flex items-center gap-4 mb-4">
                            <div class="text-2xl font-extrabold text-slate-800 w-6">{{ $r->semester }}</div>
                            <div>
                                <h3 class="font-bold text-sm text-slate-800">Semester {{ $r->semester }}</h3>
                                <p class="text-xs text-slate-500">Tahun {{ $tahun }} ({{ $tipeSemester }})</p>
                            </div>
                        </div>

                        {{-- Box Mata Kuliah & Skill --}}
                        <div class="bg-slate-50 rounded-xl p-4">
                            <div class="flex items-center gap-3 mb-1">
                                @if($r->kategori_matkul == 'Profesional')
                                    <span class="px-2.5 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-full uppercase tracking-wide">
                                        🟢 Profesional
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-blue-100 text-blue-700 text-[10px] font-bold rounded-full uppercase tracking-wide">
                                        🔵 Fondasi
                                    </span>
                                @endif
                                <h4 class="font-semibold text-slate-800 text-sm">{{ $r->nama_matkul }}</h4>
                            </div>
                            <p class="text-xs text-slate-500 ml-1 mt-2">
                                <span class="font-semibold text-slate-600">Skill:</span> {{ $r->skill_didapat }}
                            </p>
                        </div>

                    </div>
                </div>
            @empty
                {{-- Tampilan jika data roadmap di database masih kosong --}}
                <div class="text-center py-10">
                    <p class="text-slate-500">Belum ada data roadmap untuk jurusan ini.</p>
                </div>
            @endforelse

        </div>
    </div>

</body>
</html>