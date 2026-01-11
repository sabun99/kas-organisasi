<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KASKU — Kelola Kas Organisasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&family=Playfair+Display:italic,wght@0,700;1,700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">

    <nav class="fixed w-full z-50 px-8 py-5 flex justify-between items-center bg-white/80 backdrop-blur-md border-b border-slate-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/30">
                <span class="text-white font-black text-xl">K</span>
            </div>
            <span class="text-2xl font-black tracking-tighter text-slate-900 uppercase">KASKU</span>
        </div>
        
        <div class="flex items-center gap-4">
            <a href="{{ route('login') }}" class="text-slate-600 hover:text-indigo-600 font-bold text-sm px-4 transition">Masuk</a>
            <a href="{{ route('register') }}" class="bg-slate-900 text-white px-6 py-2.5 rounded-2xl text-sm font-bold shadow-xl shadow-slate-200 hover:bg-indigo-600 transition-all duration-300 active:scale-95">
                Mulai Gratis
            </a>
        </div>
    </nav>

    <main class="relative pt-40 pb-20 px-4">
        <div class="absolute top-20 left-1/4 w-72 h-72 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-pulse"></div>
        <div class="absolute top-40 right-1/4 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-pulse"></div>

        <div class="max-w-4xl mx-auto flex flex-col items-center">
            <div class="mb-8 inline-flex items-center gap-2 px-4 py-1.5 bg-indigo-50 text-indigo-600 rounded-full text-xs font-black tracking-widest uppercase">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-600"></span>
                </span>
                Motivasi Organisasi
            </div>

            <div class="glass p-12 md:p-20 rounded-[48px] shadow-2xl relative overflow-hidden group w-full text-center">
                <div class="absolute -top-10 -left-5 text-[220px] text-indigo-500/10 font-serif pointer-events-none select-none italic">“</div>
                
                <div class="relative z-10">
                    <h2 class="text-3xl md:text-5xl font-serif italic text-slate-800 leading-tight mb-10">
                        "{{ $random['quote'] ?? 'Kutipan tidak tersedia' }}"
                    </h2>
                    
                    <div class="flex flex-col items-center gap-4">
                        <div class="h-1 w-20 bg-indigo-600 rounded-full mb-2"></div>
                        <p class="text-slate-400 font-bold tracking-[0.2em] uppercase text-sm">
                            — {{ $random['author'] ?? 'Unknown' }}
                        </p>
                    </div>

                    <button onclick="window.location.reload()" class="mt-12 group flex items-center gap-3 bg-white border border-slate-200 px-8 py-4 rounded-2xl hover:bg-slate-900 hover:text-white transition-all duration-500 shadow-sm mx-auto">
                        <svg class="w-5 h-5 text-indigo-600 group-hover:rotate-180 transition-transform duration-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span class="font-black uppercase tracking-wider text-xs">Ganti Inspirasi</span>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-20 w-full">
                <div class="text-center p-6">
                    <h3 class="text-4xl font-black text-slate-900">100%</h3>
                    <p class="text-slate-400 font-bold text-xs uppercase mt-2 tracking-widest">Aman & Terenkripsi</p>
                </div>
                <div class="text-center p-6">
                    <h3 class="text-4xl font-black text-slate-900">Real-Time</h3>
                    <p class="text-slate-400 font-bold text-xs uppercase mt-2 tracking-widest">Pantau Kas Anda</p>
                </div>
                <div class="text-center p-6">
                    <h3 class="text-4xl font-black text-slate-900">Mudah</h3>
                    <p class="text-slate-400 font-bold text-xs uppercase mt-2 tracking-widest">Kelola Organisasi</p>
                </div>
            </div>
        </div>
    </main>

    <footer class="py-12 border-t border-slate-100 mt-20">
        <div class="max-w-4xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 bg-slate-900 rounded flex items-center justify-center text-[10px] text-white font-bold">K</div>
                <span class="font-black text-slate-900 tracking-tighter uppercase">KASKU</span>
            </div>
            <p class="text-slate-400 text-[10px] font-bold tracking-[0.2em] uppercase">
                &copy; 2026 KASKU — Solusi Keuangan Organisasi
            </p>
        </div>
    </footer>

</body>
</html>