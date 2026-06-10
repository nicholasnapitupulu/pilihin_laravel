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
        {{$selectedId}}
        
        <main class="flex-1 p-8 overflow-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-800">Prodi per Kampus</h1>
        <p class="text-slate-500 mt-1">Pilih kampus, centang prodi yang tersedia, lalu klik Simpan.</p>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl font-semibold mb-6 flex items-center gap-3">
            <span>✅</span> {{ session('success') }}
        </div>
    @endif

    <div class="flex gap-6">
        <div class="w-60 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="bg-slate-800 text-white px-4 py-3"><h3 class="font-bold text-xs uppercase">Pilih Kampus</h3></div>
                <ul class="divide-y divide-slate-100">
                    @foreach($allKampus as $k)
                        <li>
                            <a href="{{ route('prodi.index', ['id_kampus' => $k->id]) }}" 
                               class="flex items-center gap-3 px-4 py-3 {{ $k->id == $selectedId ? 'bg-indigo-50 border-l-4 border-indigo-500 font-bold text-indigo-700' : 'hover:bg-slate-50 border-l-4 border-transparent' }}">
                                <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 font-bold text-xs flex items-center justify-center">
                                    {{ strtoupper(substr($k->nama_kampus, 0, 2)) }}
                                </div>
                                <span class="text-sm">{{ $k->nama_kampus }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="flex-1">
            @if($selectedKampus)
                <form method="POST" action="{{ route('prodi.update') }}">
                    @csrf
                    <input type="hidden" name="id_kampus" value="{{ $selectedId }}">
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 mb-5">
                        <div class="flex items-center justify-between px-6 py-4 border-b">
                            <h2 class="text-lg font-extrabold">{{ $selectedKampus->nama_kampus }}</h2>
                            <span id="counter" class="text-sm font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">
                                {{ count($terhubung) }} aktif
                            </span>
                        </div>

                        <div class="flex gap-4 px-6 py-2 bg-slate-50 border-b text-xs">
                            <button type="button" onclick="setAll(true)" class="text-indigo-600 font-semibold">✔ Centang Semua</button>
                            <button type="button" onclick="setAll(false)" class="text-slate-500 font-semibold">✖ Hapus Semua</button>
                        </div>

                        <div class="p-6 space-y-7">
                            @foreach($allJurusan as $kat => $list)
                                <div>
                                    <p class="text-xs font-bold uppercase text-slate-400 mb-3 border-b pb-1">{{ $kat }}</p>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-2">
                                        @foreach($list as $j)
                                            @php $checked = in_array($j->id, $terhubung); @endphp
                                            <label class="prodi-label flex items-center gap-3 px-4 py-3 rounded-xl border-2 cursor-pointer transition {{ $checked ? 'border-indigo-400 bg-indigo-50' : 'border-slate-100 bg-slate-50' }}">
                                                <input type="checkbox" name="jurusan_ids[]" value="{{ $j->id }}" class="prodi-cb hidden" {{ $checked ? 'checked' : '' }}>
                                                <span class="prodi-box w-5 h-5 rounded border-2 flex items-center justify-center {{ $checked ? 'bg-indigo-600 border-indigo-600' : 'bg-white border-slate-300' }}">
                                                    <svg class="w-3 h-3 text-white {{ $checked ? '' : 'opacity-0' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                </span>
                                                <div class="min-w-0">
                                                    <p class="text-sm font-semibold text-slate-800 truncate">{{ $j->nama_jurusan }}</p>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('prodi.index', ['id_kampus' => $selectedId]) }}" class="px-6 py-3 rounded-xl bg-slate-100 font-bold">Reset</a>
                        <button type="submit" class="px-8 py-3 rounded-xl bg-indigo-600 text-white font-bold shadow-lg">💾 Simpan Perubahan</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</main>

    </div>
</body>
</html>