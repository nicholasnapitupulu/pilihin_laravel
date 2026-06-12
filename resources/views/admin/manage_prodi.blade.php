<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prodi per Kampus - PILIH.in Admin</title>
    <link href="{{ asset('src/output.css') }}" rel="stylesheet">
</head>
<body class="bg-slate-50 font-sans">
<div class="flex min-h-screen">

    @include('components.sidebar_admin')

    <main class="flex-1 p-8 overflow-auto">

        <div class="mb-6">
            <h1 class="text-3xl font-extrabold text-slate-800">Prodi per Kampus</h1>
            <p class="text-slate-500 text-sm mt-1">Pilih kampus, centang prodi yang tersedia, lalu klik Simpan.</p>
        </div>

        @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl font-semibold mb-6 flex items-center gap-2 text-sm">
            <span>✅</span> {{ session('success') }}
        </div>
        @endif

        <div class="flex gap-6 items-start">

            <div class="w-64 flex-shrink-0 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="bg-slate-900 text-white px-4 py-3">
                    <h3 class="font-bold text-xs uppercase tracking-wider">Pilih Kampus</h3>
                </div>
                <ul class="divide-y divide-slate-100 max-h-[calc(100vh-240px)] overflow-y-auto">
                    @foreach ($allKampus as $k)
                        @php $is_active = ($k->id_kampus == $selectedId); @endphp
                        <li>
                            <a href="{{ route('prodi.index', ['id_kampus' => $k->id_kampus]) }}"
                               class="flex items-center gap-3 px-4 py-3.5 transition text-xs
                                      {{ $is_active
                                          ? 'bg-indigo-50 border-l-4 border-indigo-600 font-bold text-indigo-700'
                                          : 'hover:bg-slate-50 text-slate-600 border-l-4 border-transparent' }}">
                                <div class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-600 font-bold flex items-center justify-center flex-shrink-0 text-[10px]">
                                    {{ strtoupper(substr($k->nama_kampus, 0, 2)) }}
                                </div>
                                <span class="leading-tight">{{ $k->nama_kampus }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="flex-1">
                @if ($selectedKampus)
                <form method="POST" action="{{ route('prodi.update') }}">
                    @csrf
                    <input type="hidden" name="id_kampus" value="{{ $selectedId }}">

                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-5">
                        
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h2 class="text-xl font-extrabold text-slate-800">{{ $selectedKampus->nama_kampus }}</h2>
                                <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                                    📍 <span>{{ $selectedKampus->lokasi ?? 'Bandung' }}</span> • <span>Akreditasi {{ $selectedKampus->akreditasi ?? 'Unggul' }}</span>
                                </p>
                            </div>
                            <span id="counter" class="text-xs font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">
                                {{ count($terhubung) }} aktif
                            </span>
                        </div>

                        <div class="flex gap-4 mb-6 text-xs border-b border-slate-100 pb-3">
                            <button type="button" onclick="setAll(true)" class="text-indigo-600 font-semibold hover:text-indigo-800 flex items-center gap-1">✔ Centang Semua</button>
                            <button type="button" onclick="setAll(false)" class="text-slate-500 font-semibold hover:text-slate-700 flex items-center gap-1">✖ Hapus Semua</button>
                        </div>

                        <div class="space-y-6">
                            @foreach ($allJurusan as $kat => $jurusan_list)
                            <div>
                                <h4 class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-3">{{ $kat }}</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @foreach ($jurusan_list as $j)
                                        {{-- Memeriksa apakah id_jurusan ada di dalam array $terhubung --}}
                                        @php $checked = in_array($j->id_jurusan, $terhubung); @endphp
                                        
                                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-200/60 hover:bg-white hover:border-slate-300 transition shadow-sm">
                                            <input 
                                                type="checkbox" 
                                                name="jurusan_ids[]" 
                                                value="{{ $j->id_jurusan }}" 
                                                class="prodi-cb w-4 h-4 rounded text-indigo-600 border-slate-300 focus:ring-indigo-500 cursor-pointer"
                                                {{ $checked ? 'checked' : '' }}
                                            >
                                            <div class="leading-tight">
                                                <p class="text-xs font-bold text-slate-800">{{ $j->nama_jurusan }}</p>
                                                <p class="text-[10px] text-slate-400 mt-0.5">{{ $j->kategori_relevan }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                </div>
                            @endforeach
                        </div>

                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('prodi.index', ['id_kampus' => $selectedId]) }}"
                           class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-600 font-bold text-xs hover:bg-slate-200 transition">
                            Reset
                        </a>
                        <button type="submit"
                                class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-bold text-xs hover:bg-indigo-700 shadow-md transition">
                            💾 Simpan Perubahan
                        </button>
                    </div>
                </form>

                @else
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-16 text-center text-slate-400">
                    <div class="text-4xl mb-3">🏫</div>
                    <p class="text-sm font-medium">Silakan pilih salah satu kampus di menu bagian kiri.</p>
                </div>
                @endif
            </div>

        </div>
    </main>
</div>

<script>
document.querySelectorAll('.prodi-cb').forEach(cb => {
    cb.addEventListener('change', updateCounter);
});

function updateCounter() {
    const count = document.querySelectorAll('.prodi-cb:checked').length;
    document.getElementById('counter').textContent = count + ' aktif';
}

function setAll(state) {
    document.querySelectorAll('.prodi-cb').forEach(cb => {
        cb.checked = state;
    });
    updateCounter();
}
</script>
</body>
</html>