<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - PILIH.in</title>
    <link href="{{ asset('src/output.css') }}" rel="stylesheet">
</head>
<body class="bg-slate-50 font-sans">
    <div class="flex min-h-screen">
        
        {{-- Panggil sidebar superadmin yang sudah kita buat --}}
        @include('components.sidebar_superadmin')

        <main class="flex-1 p-10">
            <h1 class="text-3xl font-extrabold text-slate-800 mb-8">Kelola Pengguna</h1>
            
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-500 uppercase bg-slate-50">
                        <tr>
                            <th class="px-6 py-4">Nama Lengkap</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Asal Sekolah</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($users as $user)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $user->nama_lengkap }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $user->asal_sekolah ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('superadmin.users.destroy', $user->id_user) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus?');">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-slate-400">Tidak ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>