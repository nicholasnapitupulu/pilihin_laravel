<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PILIH.in</title>
    <link href="{{ asset('src/output.css') }}" rel="stylesheet">
</head>

<body class="bg-base font-sans text-slate-800">

    @include('components.navbar')

    <main class="pt-32 pb-20 container mx-auto px-4 lg:px-12 flex flex-col lg:flex-row gap-8">

        <aside class="w-full lg:w-1/3">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 text-center sticky top-32">
                <div class="w-24 h-24 bg-primary text-white text-3xl flex items-center justify-center rounded-full mx-auto mb-4 font-bold shadow-lg shadow-primary/30">
                    {{ strtoupper(substr($nama_user, 0, 1)) }}
                </div>
                <h2 class="text-2xl font-bold text-slate-800">{{ $nama_user }}</h2>
                <p class="text-slate-500 mb-6">{{ $email_user }}</p>
                <div class="border-t border-slate-100 pt-6 space-y-3">
                    <a href="{{ url('/tes') }}" class="block w-full py-3 bg-secondary/10 text-secondary font-semibold rounded-xl hover:bg-secondary hover:text-white transition">
                        Ambil Tes Baru
                    </a>
                    <a href="{{ url('/kampus') }}" class="block w-full py-3 bg-primary/10 text-primary font-semibold rounded-xl hover:bg-primary hover:text-white transition">
                        Eksplorasi Kampus
                    </a>
                    
                    <form action="" method="POST" onsubmit="return confirm('Yakin ingin keluar?')">
                        @csrf
                        <button type="submit" class="block w-full py-3 bg-red-50 text-red-600 font-semibold rounded-xl hover:bg-red-500 hover:text-white transition text-center">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <section class="w-full lg:w-2/3 space-y-6">
            <h3 class="text-2xl font-bold text-slate-800 mb-6">Riwayat Rekomendasimu</h3>

            

        </section>

    </main>

    @include('components.footer')
</body>

</html>