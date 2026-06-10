<aside class="w-64 bg-slate-900 text-white p-6">
    <h2 class="text-2xl font-bold mb-8">PILIH.in <span class="text-purple-400 text-sm">superadmin</span></h2>
    <nav class="space-y-2">
        <a href="{{ route('admin.dashboard') }}" 
           class="block px-3 py-2 rounded-lg hover:bg-slate-700 hover:text-purple-400 transition {{ request()->routeIs('admin.dashboard') ? 'bg-slate-700 text-purple-400 font-bold' : '' }}">
            Dashboard
        </a>
        
        
        
        <hr class="border-slate-700 my-2">
        
        <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin keluar dari panel admin?')">
            @csrf
            <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-red-400 hover:bg-slate-700 transition">
                Logout
            </button>
        </form>
    </nav>
</aside>