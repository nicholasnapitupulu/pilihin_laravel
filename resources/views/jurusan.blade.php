<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Jurusan - PILIH.in</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800">

    @include('components.navbar')

    <main class="pt-32 pb-20 container mx-auto px-4 lg:px-12">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-slate-900 mb-3">Katalog Jurusan</h1>
            <p class="text-lg text-slate-500">Jelajahi berbagai program studi dan temukan roadmap karir yang tepat untukmu.</p>
        </div>

        {{-- Grid Wrapper Utama --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl mx-auto">
            @foreach($all_jurusan as $j)
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col h-full hover:shadow-md transition">
                    
                    {{-- Bagian Atas: Inisial Huruf & Nama Jurusan --}}
                    <div class="flex items-center gap-6 mb-4">
                        <div class="font-extrabold text-3xl text-slate-800 pl-2">
                            {{-- Mengambil huruf pertama dari nama jurusan --}}
                            {{ substr($j->nama_jurusan, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-slate-900">{{ $j->nama_jurusan }}</h3>
                            <p class="text-sm text-slate-500 mt-1">{{ $j->kategori_relevan }}</p>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <p class="text-sm text-slate-600 mb-6 flex-grow">
                        {{ $j->deskripsi_singkat }}
                    </p>

                    {{-- Tombol Roadmap Karir --}}
                    <div class="mt-auto">
                        <a href="{{ url('/jurusan/' . $j->id_jurusan . '/roadmap') }}" class="block w-full py-2.5 bg-transparent border border-slate-200 text-slate-700 rounded-xl text-sm font-semibold hover:bg-slate-50 transition text-center">
                     Lihat Roadmap Karir
                    </a>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="mt-8 flex justify-center">
            {{ $all_jurusan->links() }}
            </div>

        


    </main>

    @include('components.footer')
    

</body>
</html>