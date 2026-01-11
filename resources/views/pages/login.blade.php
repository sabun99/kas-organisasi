<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — KASKU</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        .bg-animate {
            background: linear-gradient(-45deg, #4f46e5, #06b6d4, #3b82f6);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        /* Toast Animation */
        .toast-animate {
            animation: slideIn 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
        }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .glass-toast {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-animate min-h-screen flex items-center justify-center p-6">

    <div id="toast-container" class="fixed top-5 right-5 z-[100] space-y-3"></div>

    <div class="glass-card w-full max-w-md p-10 rounded-[40px] shadow-2xl overflow-hidden relative">
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-indigo-500/20 rounded-full blur-3xl"></div>
        
        <div class="relative z-10">
            <div class="text-center mb-10">
                <div class="w-14 h-14 bg-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl shadow-indigo-200">
                    <span class="text-white font-extrabold text-2xl">K</span>
                </div>
                <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Selamat Datang</h2>
                <p class="text-gray-500 mt-2 text-sm font-medium">Gabung Di Organisasi Kami</p>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Alamat Email</label>
                    <input type="email" id="email" placeholder="nama@email.com" 
                        class="w-full px-6 py-4 rounded-2xl bg-white border border-gray-100 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 outline-none transition-all duration-300 placeholder:text-gray-300">
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Password</label>
                    <input type="password" id="password" placeholder="••••••••" 
                        class="w-full px-6 py-4 rounded-2xl bg-white border border-gray-100 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 outline-none transition-all duration-300 placeholder:text-gray-300">
                    <div class="text-right mt-2">
                        <a href="#" class="text-xs text-indigo-500 font-semibold hover:underline">Lupa Password?</a>
                    </div>
                </div>

                <button id="btnLogin" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-bold shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-1 active:scale-95 transition-all duration-300 flex items-center justify-center gap-2">
                    <span>Masuk Sekarang</span>
                </button>
            </div>

            <div class="flex items-center my-8">
                <div class="flex-1 border-t border-gray-100"></div>
                <span class="px-4 text-xs text-gray-300 font-bold uppercase tracking-widest">Atau</span>
                <div class="flex-1 border-t border-gray-100"></div>
            </div>

            <div class="text-center">
                <p class="text-sm text-gray-500 font-medium">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-indigo-600 font-extrabold hover:text-indigo-800 transition-colors">Daftar Gratis</a>
                </p>
                <a href="{{ route('home') }}" class="inline-block mt-8 text-xs text-gray-400 font-bold hover:text-gray-600 transition-all uppercase tracking-widest">
                    &larr; Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
        import { getAuth, signInWithEmailAndPassword } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";

        // Konfigurasi Firebase KASKU Anda
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

        // --- FUNGSI TOAST NOTIFICATION ---
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            
            const iconColor = type === 'success' ? 'text-green-500' : 'text-red-500';
            const iconBg = type === 'success' ? 'bg-green-50' : 'bg-red-50';
            const iconPath = type === 'success' 
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>';

            toast.className = `glass-toast toast-animate flex items-center p-4 min-w-[320px] rounded-2xl transition-all duration-300`;
            toast.innerHTML = `
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 ${iconBg} ${iconColor} rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">${iconPath}</svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">${type === 'success' ? 'Berhasil' : 'Gagal'}</p>
                        <p class="text-sm font-bold text-slate-800">${message}</p>
                    </div>
                </div>
            `;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(20px)';
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }

        const btnLogin = document.getElementById('btnLogin');

        btnLogin.addEventListener('click', async () => {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (!email || !password) {
                showToast("Mohon isi email dan password Anda.", "error");
                return;
            }

            // UI Loading
            btnLogin.innerHTML = `
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Memproses...</span>
            `;
            btnLogin.disabled = true;

            try {
                const userCredential = await signInWithEmailAndPassword(auth, email, password);
                
                showToast("Berhasil Masuk! Selamat Datang.", "success");
                
                setTimeout(() => {
                    window.location.href = "{{ route('dashboard') }}";
                }, 1500);
                
            } catch (error) {
                let message = "Terjadi kesalahan saat login.";
                
                // Mapping Error Firebase
                if (error.code === 'auth/invalid-credential' || error.code === 'auth/wrong-password' || error.code === 'auth/user-not-found') {
                    message = "Email atau Password salah.";
                } else if (error.code === 'auth/too-many-requests') {
                    message = "Terlalu banyak percobaan. Coba lagi nanti.";
                }

                showToast(message, "error");
                
                btnLogin.innerHTML = "<span>Masuk Sekarang</span>";
                btnLogin.disabled = false;
            }
        });
    </script>
</body>
</html>