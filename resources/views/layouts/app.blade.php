<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KASKU Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar-item:hover { background-color: rgba(255, 255, 255, 0.1); }
        .active-menu { background-color: #4f46e5 !important; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4); color: white !important; }
        .glass-card { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.4); }
        .toast-animate { animation: slideIn 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards; }
        @keyframes slideIn { from { transform: translateX(110%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        .glass-toast { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.5); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="bg-slate-50 flex min-h-screen">

    <div id="toast-container" class="fixed top-5 right-5 z-[120] space-y-3 pointer-events-none"></div>

    <div id="logout-modal" class="fixed inset-0 z-[110] hidden flex items-center justify-center p-6 transition-all duration-300">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div id="modal-content" class="glass-card w-full max-w-sm p-8 rounded-[40px] shadow-2xl relative z-20 text-center scale-95 opacity-0 transition-all duration-300">
            <div class="w-20 h-20 bg-rose-50 text-rose-500 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-rose-100">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Mau Keluar?</h3>
            <p class="text-slate-500 mt-2 font-medium">Anda perlu masuk kembali untuk mengakses panel KASKU.</p>
            <div class="grid grid-cols-2 gap-4 mt-8">
                <button id="cancelLogout" class="py-4 rounded-2xl font-bold text-slate-400 hover:bg-slate-50 transition-all">Batal</button>
                <button id="confirmLogout" class="py-4 bg-rose-500 text-white rounded-2xl font-bold shadow-xl shadow-rose-200 hover:bg-rose-600 active:scale-95 transition-all">Ya, Keluar</button>
            </div>
        </div>
    </div>

    @include('partials.sidebar')

    <div class="flex-1 flex flex-col">
        @include('partials.navbar')

        <main class="p-10 max-w-7xl">
            @yield('content')
        </main>
    </div>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
        import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";

        // Firebase Config (Tetap di layout karena global)
        const firebaseConfig = {
            apiKey: "AIzaSyBCk8oN8wT9t5yVkBLuZfZMgfg-iqvobJ4",
            authDomain: "kasku-731f4.firebaseapp.com",
            projectId: "kasku-731f4",
            storageBucket: "kasku-731f4.firebasestorage.app",
            messagingSenderId: "688715659094",
            appId: "1:688715659094:web:fdf9ebdc64eea1ce0088f7",
            measurementId: "G-0G0EHVSFP7"
        };

        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);

        // Toast & Logout Logic (Global)
        window.showToast = function(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            const isSuccess = type === 'success';
            toast.className = `glass-toast toast-animate flex items-center p-4 min-w-[320px] rounded-[24px] pointer-events-auto transition-all duration-300`;
            toast.innerHTML = `
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 ${isSuccess ? 'bg-emerald-50 text-emerald-500' : 'bg-rose-50 text-rose-500'} rounded-2xl flex items-center justify-center shrink-0 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${isSuccess ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>' : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>'}
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.15em] opacity-40 mb-0.5">${isSuccess ? 'Berhasil' : 'Peringatan'}</p>
                        <p class="text-sm font-extrabold text-slate-800 leading-tight">${message}</p>
                    </div>
                </div>`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'scale(0.9) translateX(20px)';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        onAuthStateChanged(auth, (user) => {
            if (user) {
                const username = user.email.split('@')[0];
                const name = username.charAt(0).toUpperCase() + username.slice(1);
                if(document.getElementById('user-display-email')) document.getElementById('user-display-email').innerText = user.email;
                if(document.getElementById('user-display-name')) document.getElementById('user-display-name').innerText = name;
                if(document.getElementById('user-greeting')) document.getElementById('user-greeting').innerText = name;
                if(document.getElementById('user-avatar')) document.getElementById('user-avatar').src = `https://ui-avatars.com/api/?name=${username}&background=6366f1&color=fff`;
            } else {
                window.location.href = "{{ route('home') }}";
            }
        });

        // Logout Modal Logic
        const modal = document.getElementById('logout-modal');
        const content = document.getElementById('modal-content');
        
        document.getElementById('btnLogout').addEventListener('click', () => {
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        });

        document.getElementById('cancelLogout').addEventListener('click', () => {
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            setTimeout(() => modal.classList.add('hidden'), 300);
        });

        document.getElementById('confirmLogout').addEventListener('click', async () => {
            try {
                await signOut(auth);
                showToast("Berhasil keluar sistem", "success");
            } catch (e) {
                showToast("Gagal logout", "error");
            }
        });
    </script>
    @stack('scripts')
</body>
</html>