<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eksplorasi Kampus - PILIH.in</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        .bg-primary { background-color: #4f46e5; }
        .text-primary { color: #4f46e5; }
    </style>
</head>
<body class="bg-base font-sans text-slate-800">

    @include('components.navbar')

    <main class="pt-32 pb-20 container mx-auto px-4 lg:px-12">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-slate-900 mb-2">Eksplorasi Kampus Impian LOLOLOLOL</h1>
            <p class="text-lg text-slate-500">Temukan universitas terbaik untuk menunjang roadmap karirmu.</p>
        </div>

        {{-- Filter Input --}}
        <div class="max-w-3xl mx-auto bg-white p-4 rounded-2xl shadow-sm border border-slate-200 flex flex-col md:flex-row gap-4 mb-12">
            <input type="text" id="searchInput" onkeyup="filterKampus()" placeholder="Cari nama kampus atau lokasi..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-primary">
            <select id="filterAkreditasi" onchange="filterKampus()" class="w-full md:w-48 px-4 py-3 rounded-xl border border-slate-200 bg-white focus:outline-none focus:border-primary">
                <option value="Semua">Semua Akreditasi</option>
                <option value="Unggul">Unggul</option>
                <option value="A">A</option>
                <option value="B">B</option>
            </select>
        </div>

        {{-- Grid Wrapper Utama --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="campusGrid">
            @foreach($all_kampus as $k)
                <div class="kampus-card bg-white p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-lg transition href-pointer" data-akreditasi="{{ $k->akreditasi }}">
                    
                    {{-- Bagian Atas: Logo, Nama, Lokasi --}}
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center overflow-hidden border border-slate-100 shadow-sm flex-shrink-0">
                            @if(!empty($k->logo_kampus))
                                <img src="{{ asset('img/' . $k->logo_kampus) }}" alt="Logo {{ $k->nama_kampus }}" class="w-full h-full object-contain p-1">
                            @else
                                <div class="text-3xl">🏫</div>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-slate-800 kampus-nama">{{ $k->nama_kampus }}</h3>
                            <p class="text-sm text-slate-500 kampus-lokasi">📍 {{ $k->lokasi }}</p>
                        </div>
                    </div>

                    {{-- Bagian Tengah: Akreditasi & Biaya --}}
                    <div class="space-y-2 mb-6">
                        <div class="flex justify-between items-center text-sm border-b border-slate-100 pb-2">
                            <span class="text-slate-500">Akreditasi</span>
                            <span class="font-bold text-primary bg-primary/10 px-3 py-1 rounded-full">{{ $k->akreditasi }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm border-b border-slate-100 pb-2">
                            <span class="text-slate-500">Estimasi UKT</span>
                            <span class="font-semibold text-slate-700">{{ $k->estimasi_biaya }}</span>
                        </div>
                    </div>

                    {{-- Bagian Bawah: Jurusan Dinamis dari Database --}}
                    <div class="flex flex-wrap gap-1 mb-4">
                        @foreach($k->jurusan as $j)
                            <span class="text-xs bg-slate-50 text-slate-600 px-2 py-1 rounded-full border border-slate-100">
                                {{ $j->nama_jurusan }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Tombol Navigasi Luar --}}
        <div class="mt-8">
            <a href="{{ url('/jurusan') }}" class="block w-full py-2 bg-slate-50 border border-slate-200 text-slate-950 rounded-xl font-semibold hover:bg-primary hover:text-white transition text-center mb-4">
                Lihat Katalog Jurusan
            </a>
        </div>
    </main>

    @include('components.footer')

    {{-- Fitur Instant Client-Side Search & Filter --}}
    <script>
        function filterKampus() {
            let input = document.getElementById('searchInput').value.toLowerCase();
            let filterAkr = document.getElementById('filterAkreditasi').value;
            let cards = document.getElementsByClassName('kampus-card');

            for (let i = 0; i < cards.length; i++) {
                let card = cards[i];
                let nama = card.querySelector('.kampus-nama').innerText.toLowerCase();
                let lokasi = card.querySelector('.kampus-lokasi').innerText.toLowerCase();
                let akreditasi = card.getAttribute('data-akreditasi');

                let matchSearch = nama.includes(input) || lokasi.includes(input);
                let matchAkr = (filterAkr === "Semua") || (akreditasi === filterAkr);

                card.style.display = (matchSearch && matchAkr) ? "block" : "none";
            }
        }
    </script>
</body>
</html>