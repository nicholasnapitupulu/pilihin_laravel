<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Admin - PILIH.in</title>
    <link href="{{ asset('src/output.css') }}" rel="stylesheet"> </head>
<body class="bg-slate-50 flex min-h-screen">
    @include('components.sidebar_superadmin')

    <main class="flex-1 p-10">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-800">Manajemen Admin</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola data akun operasional untuk admin PILIH.in</p>
            </div>
            <button onclick="toggleModal('modalTambah')" class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-md transition duration-300">
                + Tambah Admin
            </button>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 text-xs font-bold uppercase tracking-wider border-b border-slate-100">
                        <th class="px-6 py-4">ID User</th>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Status Akun</th>
                        <th class="px-6 py-4 text-center">Aksi Kontrol</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-600 divide-y divide-slate-50">
                    @forelse($users as $row)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="px-6 py-4 font-mono text-slate-400">#{{ $row->id_user }}</td>
                        <td class="px-6 py-4 font-bold text-slate-800">{{ $row->nama_lengkap }}</td>
                        <td class="px-6 py-4">{{ $row->email }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ ($row->status ?? 'aktif') === 'aktif' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                {{ ucfirst($row->status ?? 'aktif') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 flex justify-center gap-4">
                            <button onclick="openEditModal({{ json_encode($row) }})" class="text-purple-600 font-bold hover:text-purple-800">Edit</button>
                            <form action="{{ route('superadmin.admin.toggle_status', $row->id_user) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-amber-600 font-bold hover:text-amber-800">
                                    {{ ($row->status ?? 'aktif') === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            <form action="{{ route('superadmin.admin.destroy', $row->id_user) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-rose-500 font-bold hover:text-rose-700">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-10 text-slate-400">Belum ada admin terdaftar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <script>
        function toggleModal(id) { document.getElementById(id).classList.toggle('hidden'); }
        function openEditModal(admin) {
            document.getElementById('edit_nama').value = admin.nama_lengkap;
            document.getElementById('edit_email').value = admin.email;
            document.getElementById('formEditAdmin').action = `/superadmin/admin/${admin.id_user}`;
            toggleModal('modalEdit');
        }
    </script>
</body>