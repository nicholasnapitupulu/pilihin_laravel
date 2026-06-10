<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Admin - PILIH.in</title>
     <link href="{{ asset('src/output.css') }}" rel="stylesheet">
</head>
<body class="bg-slate-50 flex min-h-screen relative">
    
    @include('components.sidebar_superadmin')

    <main class="flex-1 p-10 z-10">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-extrabold text-slate-800">Manajemen Admin</h1>
            <button onclick="toggleModal('modalTambah')" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-2.5 rounded-xl font-bold hover:shadow-lg hover:shadow-purple-500/30 hover:-translate-y-0.5 transition duration-300">
                + Tambah Admin
            </button>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="p-4 font-bold text-slate-600">ID</th>
                        <th class="p-4 font-bold text-slate-600">Nama</th>
                        <th class="p-4 font-bold text-slate-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $row)
                    <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition">
                        <td class="p-4 text-slate-500">#{{ $row->id_user }}</td>
                        <td class="p-4 font-bold text-slate-800">{{ $row->nama_lengkap }}</td>
                        <td class="p-4 text-center space-x-2 flex justify-center items-center">
                            <button class="text-indigo-600 font-bold text-sm hover:underline mr-2">Edit</button>
                            
                            <form action="{{ route('user.destroy', $row->id_user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus admin ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 font-bold text-sm hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-slate-400">Belum ada data admin.</td>
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

            <form action="{{ route('user.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Nama Admin</label>
                    <input type="text" name="nama_lengkap" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 outline-none transition font-medium" placeholder="Budi">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Email</label>
                    <input type="text" name="email" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 outline-none transition font-medium" placeholder="budi@gmail.com">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 outline-none transition font-medium" placeholder="****">
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="toggleModal('modalTambah')" class="w-1/3 bg-slate-100 text-slate-600 font-bold py-3.5 rounded-xl hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" class="w-2/3 bg-slate-900 text-white font-bold py-3.5 rounded-xl hover:bg-purple-700 shadow-lg transition">Simpan Admin</button>
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