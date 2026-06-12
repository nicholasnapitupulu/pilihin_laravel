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

    <main class="pt-32 pb-20 container mx-auto px-4 lg:px-12 flex flex-col lg:flex-row gap-8">

        <aside class="w-full lg:w-1/3 flex-shrink-0">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 text-center sticky top-32 flex flex-col items-center justify-center">
                
                <div class="flex justify-center items-center w-full mb-4">
                    <div class="relative w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-lg ring-2 ring-indigo-100">
                        @if(isset($user_foto) && $user_foto && file_exists(public_path('user_foto/' . $user_foto)))
                            <img src="{{ asset('user_foto/' . $user_foto) }}" 
                                alt="Foto Profil"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-indigo-600 flex items-center justify-center">
                                <span class="text-white text-4xl font-bold">
                                    {{ strtoupper(substr($nama_user, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <form id="upload-foto-form" action="{{ route('profile.update-photo') }}" method="POST" enctype="multipart/form-data" class="mb-5 block w-full text-center">
                    @csrf
                    <label for="input-foto" class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold rounded-full cursor-pointer transition duration-200 shadow-sm">
                        <i class="fa-solid fa-camera text-[10px]"></i> Ganti Foto
                    </label>
                    <input type="file" id="input-foto" name="foto_profil" class="hidden" accept="image/*" onchange="submitFoto()">
                </form>

                <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight mb-1 w-full truncate">{{ $nama_user }}</h2>
                <p class="text-slate-400 text-sm mb-6 w-full truncate">{{ $email_user }}</p>
                
                <div class="border-t border-slate-100 pt-6 space-y-4 w-full">

                    <a href="{{ url('/tes') }}"
                    class="block w-full py-3.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition duration-200 text-center text-sm shadow-sm">
                        Ambil Tes Baru
                    </a>

                    <a href="{{ url('/kampus') }}" 
                    class="block w-full py-3.5 bg-blue-100 border border-blue-200 text-slate-700 font-bold rounded-xl text-center text-sm transition-all duration-300 ease-in-out hover:bg-blue-200 hover:text-slate-900 hover:shadow-md hover:shadow-blue-100/50 active:scale-[0.97] active:duration-75 select-none">
                        Eksplorasi Kampus
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" 
                                class="w-full py-3.5 bg-red-50 border border-red-100 text-red-600 font-bold rounded-xl text-center text-sm transition-all duration-300 ease-in-out hover:bg-red-100 hover:text-red-700 hover:shadow-md hover:shadow-red-100/50 active:scale-[0.97] active:duration-75 select-none">
                            Logout Akun
                        </button>
                    </form>

                </div>
        </aside>

    <section class="w-full lg:w-2/3 space-y-5">
        <h3 class="text-2xl font-extrabold text-slate-800 mb-6 tracking-tight">Riwayat Rekomendasimu</h3>

        @if(isset($riwayat_result) && count($riwayat_result) > 0)
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
                            <p class="text-xs text-slate-400 flex items-center gap-1">
                                <i class="fa-solid fa-tags text-[10px]"></i> Minat dominan: {{ $riwayat->jurusan->kategori_relevan ?? 'Umum' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end flex-shrink-0">
                        <a href="{{ url('/tes/hasil/' . $riwayat->id_hasil) }}" class="w-full sm:w-auto px-6 py-3 bg-slate-50 border border-slate-200 text-slate-700 font-bold text-xs rounded-xl hover:bg-slate-100 hover:border-slate-300 active:scale-[0.97] transition duration-150 text-center shadow-sm">
                            Detail Hasil
                        </a>
                    </div>
                </div>
            @endforeach
        @else
            <div class="bg-white rounded-3xl p-12 border border-dashed border-slate-200 text-center text-slate-400">
                <i class="fa-solid fa-folder-open text-4xl mb-3 block text-slate-300"></i>
                <p class="font-medium text-slate-500">Belum ada riwayat pengerjaan tes.</p>
            </div>
        @endif
    </section>

    </main>

    @include('components.footer')

    <script>
        function submitFoto() {
            const input = document.getElementById('input-foto');
            if (input.files && input.files[0]) {
                document.getElementById('upload-foto-form').submit();
            }
        }
    </script>
</body>

</html>