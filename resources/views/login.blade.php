<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autentikasi - PILIH.in</title>
    <link href="{{ asset('src/output.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-slate-50 font-sans text-slate-800 min-h-screen flex items-center justify-center relative overflow-hidden">

    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-purple-600/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl"></div>

    <div class="relative z-10 w-full max-w-md p-8 bg-white/70 backdrop-blur-lg border border-slate-200 rounded-3xl shadow-xl mx-4">
        <div class="flex flex-col items-center text-center mb-8 w-full">
            <a href="{{ url('/') }}" class="hover:opacity-80 transition hover:scale-105 duration-300 mb-2">
                <img src="{{ asset('img/LOGO PILIH.IN-02.png') }}" alt="PILIH.in Logo" class="h-10 w-auto object-contain rounded-lg">
            </a>
            <p class="text-slate-500 text-sm" id="form-subtitle">Masuk untuk menyimpan roadmap karirmu.</p>
        </div>

        {{-- Error handling global dari controller (Auth::attempt gagal) --}}
        @if (session('error'))
            <div class="bg-red-100 text-red-600 p-3 rounded-lg text-sm mb-4 text-center font-medium border border-red-200">
                {{ session('error') }}
            </div>
        @endif

        {{-- Error handling dari form validation Laravel --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-600 p-3 rounded-lg text-sm mb-4 border border-red-200">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM LOGIN --}}
        <form id="form-login" action="{{ route('login') }}" method="POST" class="space-y-5 block" onsubmit="return validasiLogin()">
            @csrf
            <input type="hidden" name="redirect" value="{{ $redirect }}">
            
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                <input type="email" id="login-email" name="email" value="{{ old('email') }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-purple-600 focus:ring-2 focus:ring-purple-600/20 outline-none transition"
                    placeholder="contoh@email.com">
                <span id="err-login-email" class="text-red-500 text-xs hidden">Email tidak boleh kosong!</span>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Password</label>
                <input type="password" id="login-password" name="password"
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-purple-600 focus:ring-2 focus:ring-purple-600/20 outline-none transition"
                    placeholder="••••••••">
                <span id="err-login-pass" class="text-red-500 text-xs hidden">Password tidak boleh kosong!</span>
            </div>
            <button type="submit"
                class="w-full bg-purple-600 text-white font-bold py-3 rounded-xl hover:opacity-90 transition shadow-lg shadow-purple-600/30">
                Masuk Sekarang
            </button>
            <p class="text-center text-sm text-slate-500 mt-4">Belum punya akun? 
                <button type="button" onclick="toggleForm('register')" class="text-purple-600 font-bold hover:underline">Daftar di sini</button>
            </p>
        </form>

        {{-- FORM REGISTER --}}
        <form id="form-register" action="{{ route('register') }}" method="POST" class="space-y-4 hidden" onsubmit="return validasiRegister()">
            @csrf
            <input type="hidden" name="redirect" value="{{ $redirect }}">
            
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text" id="reg-nama" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-purple-600 focus:ring-2 focus:ring-purple-600/20 outline-none transition"
                    placeholder="Nama sesuai ijazah">
                <span id="err-reg-nama" class="text-red-500 text-xs hidden">Nama lengkap tidak boleh kosong!</span>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                <input type="email" id="reg-email" name="email" value="{{ old('email') }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-purple-600 focus:ring-2 focus:ring-purple-600/20 outline-none transition"
                    placeholder="contoh@email.com">
                <span id="err-reg-email" class="text-red-500 text-xs hidden">Email tidak boleh kosong!</span>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Password</label>
                <input type="password" id="reg-password" name="password"
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-purple-600 focus:ring-2 focus:ring-purple-600/20 outline-none transition"
                    placeholder="Minimal 8 karakter">
                <span id="err-reg-pass" class="text-red-500 text-xs hidden">Password minimal 8 karakter!</span>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Asal Sekolah</label>
                <input type="text" id="reg-asal_sekolah" name="asal_sekolah" value="{{ old('asal_sekolah') }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-purple-600 focus:ring-2 focus:ring-purple-600/20 outline-none transition"
                    placeholder="SMAN 2 Bojonegoro">
                <span id="err-reg-asal_sekolah" class="text-red-500 text-xs hidden">Masukkan asal sekolahmu</span>
            </div>
            <button type="submit"
                class="w-full bg-purple-600 text-white font-bold py-3 rounded-xl hover:opacity-90 transition shadow-lg shadow-purple-600/30">
                Buat Akun
            </button>
            <p class="text-center text-sm text-slate-500 mt-4">Sudah punya akun? 
                <button type="button" onclick="toggleForm('login')" class="text-purple-600 font-bold hover:underline">Masuk</button>
            </p>
        </form>
    </div>

    <script>
        function toggleForm(type) {
            const loginForm = document.getElementById('form-login');
            const regForm = document.getElementById('form-register');
            const subtitle = document.getElementById('form-subtitle');

            if (type === 'register') {
                loginForm.classList.add('hidden');
                regForm.classList.remove('hidden');
                subtitle.innerText = "Mulai petakan masa depanmu bersama kami.";
            } else {
                regForm.classList.add('hidden');
                loginForm.classList.remove('hidden');
                subtitle.innerText = "Masuk untuk menyimpan roadmap karirmu.";
            }
        }

        function validasiLogin() {
            let valid = true;
            let email = document.getElementById('login-email').value;
            let pass = document.getElementById('login-password').value;

            if (email === "") { document.getElementById('err-login-email').classList.remove('hidden'); valid = false; }
            else { document.getElementById('err-login-email').classList.add('hidden'); }

            if (pass === "") { document.getElementById('err-login-pass').classList.remove('hidden'); valid = false; }
            else { document.getElementById('err-login-pass').classList.add('hidden'); }

            return valid;
        }

        function validasiRegister() {
            let valid = true;
            let nama = document.getElementById('reg-nama').value;
            let email = document.getElementById('reg-email').value;
            let pass = document.getElementById('reg-password').value;
            let sekolah = document.getElementById('reg-asal_sekolah').value;

            if (nama === "") { document.getElementById('err-reg-nama').classList.remove('hidden'); valid = false; }
            else { document.getElementById('err-reg-nama').classList.add('hidden'); }

            if (email === "") { document.getElementById('err-reg-email').classList.remove('hidden'); valid = false; }
            else { document.getElementById('err-reg-email').classList.add('hidden'); }

            if (pass === "" || pass.length < 8) { document.getElementById('err-reg-pass').classList.remove('hidden'); valid = false; }
            else { document.getElementById('err-reg-pass').classList.add('hidden'); }

            if (sekolah === "") { document.getElementById('err-reg-asal_sekolah').classList.remove('hidden'); valid = false; }
            else { document.getElementById('err-reg-asal_sekolah').classList.add('hidden'); }

            return valid;
        }

        // Otomatis swasta form ke register jika validasi register dari server gagal kembali
        @if ($errors->has('nama_lengkap') || $errors->has('asal_sekolah') || (old('nama_lengkap') && $errors->has('email')))
            window.onload = function() {
                toggleForm('register');
            };
        @endif
    </script>
</body>

</html>