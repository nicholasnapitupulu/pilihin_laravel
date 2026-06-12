<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Jurusan - PILIH.in</title>
     <link href="{{ asset('src/output.css') }}" rel="stylesheet">
</head>
<body class="bg-slate-50 flex min-h-screen relative">
    
    @include('components.sidebar_admin')

    <main class="flex-1 p-10 z-10">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-800">Manajemen Jurusan</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola data jurusan dan kategori minat di PILIH.in</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('jurusan.export_pdf') }}" 
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 hover:bg-slate-200 rounded-xl font-bold text-sm shadow-sm transition-all duration-200 transform hover:-translate-y-0.5 active:scale-95 focus:outline-none focus:ring-2 focus:ring-slate-300">
                    <span class="text-base select-none" style="color: #dc2626;">📄</span> 
                    <span class="text-slate-700">Export PDF</span>
                </a>

                <button onclick="toggleModal('modalTambah')" 
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm shadow-md transition-all duration-200 transform hover:-translate-y-0.5 active:scale-95 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    <span class="text-base select-none">+</span> 
                    <span>Tambah Jurusan</span>
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 text-emerald-600 p-4 rounded-2xl font-bold mb-6 border border-emerald-100 shadow-sm flex items-center justify-between">
                <span>✅ {{ session('success') }}</span>
                <a href="{{ route('jurusan.admin_index') }}" class="text-emerald-800 hover:text-emerald-900">✖</a>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="p-4 font-bold text-slate-600">ID</th>
                        <th class="p-4 font-bold text-slate-600">Nama Jurusan</th>
                        <th class="p-4 font-bold text-slate-600">Kategori Minat</th>
                        <th class="p-4 font-bold text-slate-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($majors as $row)
                    <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition">
                        <td class="p-4 text-slate-500">#{{ $row->id_jurusan }}</td>
                        <td class="p-4 font-bold text-slate-800">{{ $row->nama_jurusan }}</td>
                        <td class="p-4">
                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold">
                                {{ $row->kategori_relevan }}
                            </span>
                        </td>
                        <td class="p-4 text-center space-x-2 flex justify-center items-center">
                            <button onclick="openEditModal({{ json_encode($row) }})" class="text-indigo-600 font-bold text-sm hover:underline mr-2">Edit</button>
                            
                            <form action="{{ route('jurusan.destroy', $row->id_jurusan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jurusan ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 font-bold text-sm hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-slate-400">Belum ada data jurusan.</td>
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
                <h2 class="text-2xl font-extrabold text-slate-800">Tambah Jurusan Baru</h2>
                <button onclick="toggleModal('modalTambah')" class="text-slate-400 hover:text-red-500 text-2xl font-bold transition">&times;</button>
            </div>

            <form action="{{ route('jurusan.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Nama Jurusan</label>
                    <input type="text" name="nama_jurusan" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 outline-none transition font-medium" placeholder="Contoh: Sistem Informasi">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Kategori Minat (Penghubung Tes)</label>
                    <input type="text" name="kategori_relevan" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 outline-none transition font-medium" placeholder="Contoh: Teknologi / Bisnis / Seni">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Deskripsi Singkat</label>
                    <textarea name="deskripsi_singkat" rows="3" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 outline-none transition font-medium resize-none" placeholder="Tuliskan deskripsi singkat mengenai jurusan..."></textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Prospek Karir</label>
                    <textarea name="prospek_karir" rows="2" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 outline-none transition font-medium resize-none" placeholder="Contoh: System Analyst, Developer, Business Analyst"></textarea>
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="toggleModal('modalTambah')" class="w-1/3 bg-slate-100 text-slate-600 font-bold py-3.5 rounded-xl hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" class="w-2/3 bg-slate-900 text-white font-bold py-3.5 rounded-xl hover:bg-purple-700 shadow-lg transition">Simpan Jurusan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEdit" class="fixed inset-0 z-50 hidden flex items-center justify-center">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('modalEdit')"></div>
        
        <div class="relative bg-white w-full max-w-lg rounded-[2rem] shadow-2xl p-8 transform scale-95 opacity-0 transition-all duration-300" id="modalEditContent">
            
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-extrabold text-slate-800">Edit Data Jurusan</h2>
                <button onclick="toggleModal('modalEdit')" class="text-slate-400 hover:text-red-500 text-2xl font-bold transition">&times;</button>
            </div>

            <form id="formEditJurusan" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Nama Jurusan</label>
                    <input type="text" name="nama_jurusan" id="edit_nama_jurusan" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 outline-none transition font-medium">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Kategori Minat</label>
                    <input type="text" name="kategori_relevan" id="edit_kategori_relevan" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 outline-none transition font-medium">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Deskripsi Singkat</label>
                    <textarea name="deskripsi_singkat" id="edit_deskripsi_singkat" rows="3" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 outline-none transition font-medium resize-none"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Prospek Karir</label>
                    <textarea name="prospek_karir" id="edit_prospek_karir" rows="2" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 outline-none transition font-medium resize-none"></textarea>
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="toggleModal('modalEdit')" class="w-1/3 bg-slate-100 text-slate-600 font-bold py-3.5 rounded-xl hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" class="w-2/3 bg-slate-900 text-white font-bold py-3.5 rounded-xl hover:bg-indigo-700 shadow-lg transition">Simpan Perubahan</button>
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

        function openEditModal(data) {
            // 1. Isi value input modal edit secara otomatis berdasarkan data baris yang diklik
            document.getElementById('edit_nama_jurusan').value = data.nama_jurusan;
            document.getElementById('edit_kategori_relevan').value = data.kategori_relevan;
            document.getElementById('edit_deskripsi_singkat').value = data.deskripsi_singkat;
            document.getElementById('edit_prospek_karir').value = data.prospek_karir;

            // 2. Set action form agar mengarah ke route update id yang tepat
            document.getElementById('formEditJurusan').action = `/admin/jurusan/${data.id_jurusan}`;

            // 3. Tampilkan modal edit dengan animasi bawaanmu
            const modal = document.getElementById('modalEdit');
            const content = document.getElementById('modalEditContent');
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }
    </script>
</body>
</html>