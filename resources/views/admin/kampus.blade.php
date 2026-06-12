<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kampus - PILIH.in Admin</title>
    <link href="{{ asset('src/output.css') }}" rel="stylesheet">
</head>
<body class="bg-slate-50 flex min-h-screen">

    @include('components.sidebar_admin')
    

    <main class="flex-1 p-10">
 
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Manajemen Kampus</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola data universitas, akreditasi, dan program studi PILIH.in</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('kampus.export_pdf') }}" 
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 hover:bg-slate-200 rounded-xl font-bold text-sm shadow-sm transition-all duration-200 transform hover:-translate-y-0.5 active:scale-95 focus:outline-none focus:ring-2 focus:ring-slate-300">
                    <span class="text-base select-none" style="color: #dc2626;">📄</span> 
                    <span class="text-slate-700">Export PDF</span>
                </a>

                <button onclick="toggleModal('modalTambah')" 
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm shadow-md transition-all duration-200 transform hover:-translate-y-0.5 active:scale-95 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    <span class="text-base select-none">+</span> 
                    <span>Tambah Kampus</span>
                </button>
                
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-100 text-emerald-700 p-4 rounded-xl font-bold mb-6 flex justify-between">
                <span>✅ {{ session('success') }}</span>
                <a href="{{ route('kampus.admin_index') }}" class="text-emerald-800 hover:text-emerald-900">✖</a>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="p-4 font-bold text-slate-600">ID</th>
                        <th class="p-4 font-bold text-slate-600">Nama Kampus</th>
                        <th class="p-4 font-bold text-slate-600">Akreditasi</th>
                        <th class="p-4 font-bold text-slate-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($campuses as $campus)
                    <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition">
                        <td class="p-4 text-slate-500">#{{ $campus->id_kampus }}</td>
                        <td class="p-4 flex items-center gap-3">
                            <img src="{{ $campus->logo_kampus ? asset('img/' . $campus->logo_kampus) : asset('img/default-campus.jpg') }}" 
                            alt="Logo Kampus" 
                            class="w-12 h-12 rounded-xl object-cover border border-slate-100">
                            
                            <span class="font-bold text-slate-800">{{ $campus->nama_kampus }}</span>
                        </td>
                        <td class="p-4">
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                                {{ $campus->akreditasi }}
                            </span>
                        </td>
                        <td class="p-4 text-center flex items-center justify-center space-x-3">
                            <a href="{{ route('prodi.index', ['id_kampus' => $campus->id_kampus]) }}" class="text-indigo-600 font-bold text-sm hover:underline">📌 Atur Prodi</a>
                            
                            <form action="{{ route('kampus.destroy', $campus->id_kampus) }}" method="POST" onsubmit="return confirm('Hapus kampus ini dari sistem?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 font-bold text-sm hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-slate-400">Belum ada data kampus.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <div id="modalTambah" class="fixed inset-0 z-50 hidden flex items-center justify-center">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('modalTambah')"></div>
        
        <div class="relative bg-white w-full max-w-lg rounded-[2rem] shadow-2xl p-8 transform scale-95 opacity-0 transition-all duration-300" id="modalContent">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-extrabold text-slate-800">Tambah Kampus Baru</h2>
                <button onclick="toggleModal('modalTambah')" class="text-slate-400 hover:text-red-500 text-2xl font-bold transition">&times;</button>
            </div>

            <form action="{{ route('kampus.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Nama Kampus</label>
                    <input type="text" name="nama_kampus" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition font-medium" placeholder="Contoh: Universitas Indonesia">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Lokasi</label>
                    <input type="text" name="lokasi" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition font-medium" placeholder="Contoh: Depok, Jawa Barat">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Akreditasi</label>
                    <select name="akreditasi" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none font-medium">
                        <option value="Unggul">Unggul</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="Baik Sekali">Baik Sekali</option>
                        <option value="Baik">Baik</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Estimasi UKT/SMT</label>
                    <input type="text" name="estimasi_biaya" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition font-medium" placeholder="Contoh: Rp. 500.000 - Rp. 3.000.000 / SMT">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Foto / Gambar Kampus</label>
                    <input type="file" name="gambar" required accept="image/*" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-500 file:mr-4 file:py-1.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition custom-file-input outline-none">
                    <p class="text-xs text-slate-400 mt-1">Format: JPG, JPEG, atau PNG. Maksimal 2MB.</p>
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="toggleModal('modalTambah')" class="w-1/3 bg-slate-100 text-slate-600 font-bold py-3.5 rounded-xl hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" class="w-2/3 bg-indigo-600 text-white font-bold py-3.5 rounded-xl hover:bg-indigo-700 shadow-lg transition">Simpan Kampus</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(modalID) {
            const modal = document.getElementById(modalID);
            const content = document.getElementById('modalContent');
            
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    content.classList.remove('scale-95', 'opacity-0');
                    content.classList.add('scale-100', 'opacity-100');
                }, 10);
            } else {
                content.classList.remove('scale-100', 'opacity-100');
                content.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }
        }
    </script>


</body>
</html>