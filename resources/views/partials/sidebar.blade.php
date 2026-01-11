<aside class="w-72 bg-slate-900 text-white flex flex-col hidden md:flex border-r border-slate-800">
    <div class="p-8">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/30">
                <span class="text-white font-black text-xl">K</span>
            </div>
            <span class="text-2xl font-black tracking-tighter text-white">KASKU</span>
        </div>
    </div>
    <nav class="flex-1 px-4 space-y-2 mt-4">
        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-4 ml-4">Menu Utama</p>
        
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 {{ request()->routeIs('dashboard') ? 'active-menu' : 'sidebar-item text-slate-400' }} p-4 rounded-2xl font-bold transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Dashboard
        </a>

        <a href="{{ route('history') }}" class="flex items-center gap-3 {{ request()->routeIs('history') ? 'active-menu' : 'sidebar-item text-slate-400' }} p-4 rounded-2xl font-bold transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            History
        </a>

        <a href="{{ route('transaksi') }}" class="flex items-center gap-3 {{ request()->routeIs('transaksi') ? 'active-menu' : 'sidebar-item text-slate-400' }} p-4 rounded-2xl font-bold transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            Transaksi
        </a>
    </nav>
    <div class="p-6">
        <div class="bg-slate-800/50 p-4 rounded-2xl border border-slate-700">
            <p class="text-xs text-slate-500">Butuh Bantuan?</p>
            <a href="#" class="text-xs font-bold text-indigo-400 hover:underline">Hubungi Support</a>
        </div>
    </div>
</aside>