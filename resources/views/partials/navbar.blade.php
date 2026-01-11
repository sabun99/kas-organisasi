<header class="bg-white/80 backdrop-blur-md sticky top-0 z-10 px-8 py-4 flex justify-between items-center border-b border-slate-100">
    <div><h2 class="text-sm font-bold text-slate-400 uppercase tracking-widest">@yield('header_title', 'Ringkasan Keuangan')</h2></div>
    <div class="flex items-center gap-6">
        <div class="flex items-center gap-3 border-r pr-6 border-slate-100">
            <div class="text-right">
                <p id="user-display-name" class="text-sm font-black text-slate-800 leading-none">Memuat...</p>
                <p id="user-display-email" class="text-[10px] font-medium text-slate-400 mt-1">...</p>
            </div>
            <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center border-2 border-white shadow-sm overflow-hidden">
                <img id="user-avatar" src="https://ui-avatars.com/api/?name=User&background=6366f1&color=fff" alt="">
            </div>
        </div>
        <button id="btnLogout" class="group flex items-center gap-2 text-slate-400 hover:text-red-500 transition-all">
            <span class="text-xs font-bold uppercase tracking-wider">Keluar</span>
            <div class="p-2 rounded-lg group-hover:bg-red-50 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            </div>
        </button>
    </div>
</header>