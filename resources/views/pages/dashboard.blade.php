@extends('layouts.app')

@section('title', 'Dashboard — KASKU')
@section('header_title', 'Ringkasan Keuangan')

@section('content')
    <div class="mb-10">
        <h1 class="text-4xl font-black text-slate-900 tracking-tight">Halo, <span class="text-indigo-600" id="user-greeting">User</span>! 👋</h1>
        <p class="text-slate-500 mt-2">Selamat datang kembali di panel kendali **KASKU** Anda.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em] relative z-10">Kas Masuk</p>
            <p id="total-masuk" class="text-3xl font-black text-slate-900 mt-4 relative z-10 transition-all duration-300">Rp 0</p>
        </div>
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-rose-50 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em] relative z-10">Kas Keluar</p>
            <p id="total-keluar" class="text-3xl font-black text-slate-900 mt-4 relative z-10 transition-all duration-300">Rp 0</p>
        </div>
        <div class="bg-indigo-600 p-8 rounded-[32px] shadow-xl shadow-indigo-200 relative overflow-hidden">
            <p class="text-xs font-bold text-indigo-200 uppercase tracking-[0.2em] relative z-10">Saldo KASKU</p>
            <p id="total-saldo" class="text-3xl font-black text-white mt-4 relative z-10 transition-all duration-300">Rp 0</p>
        </div>
    </div>

    <div class="mt-12 bg-white rounded-[40px] shadow-sm border border-slate-100 p-10">
        <div class="flex justify-between items-center mb-10">
            <h3 class="text-xl font-black text-slate-800">Riwayat Terkini</h3>
            <a href="{{ url('/history') }}" class="text-indigo-600 font-bold text-sm hover:underline flex items-center gap-1">
                Lihat Semua 
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        
        <div id="dashboard-recent-list" class="space-y-4">
            <div class="flex flex-col items-center justify-center py-20 border-2 border-dashed border-slate-100 rounded-[30px]" id="empty-dashboard">
                <p class="text-slate-400 font-medium">Memuat data aktivitas...</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="module">
    import { getFirestore, collection, onSnapshot, query, orderBy, limit } 
    from "https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js";
    import { getAuth } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";

    const db = getFirestore();
    const auth = getAuth();
    const transCollection = collection(db, "transaksi");

    // --- Format Rupiah ---
    const formatIDR = (num) => "Rp " + num.toLocaleString('id-ID');

    // --- Update UI Statistik ---
    function updateStats(docs) {
        let masuk = 0;
        let keluar = 0;

        docs.forEach(doc => {
            const data = doc.data();
            if (data.jenis === 'Pemasukan') masuk += data.nominal;
            else keluar += data.nominal;
        });

        document.getElementById('total-masuk').innerText = formatIDR(masuk);
        document.getElementById('total-keluar').innerText = formatIDR(keluar);
        document.getElementById('total-saldo').innerText = formatIDR(masuk - keluar);
    }

    // --- Update Riwayat Terkini (5 Data Terakhir) ---
    function updateRecentList(docs) {
        const container = document.getElementById('dashboard-recent-list');
        const emptyState = document.getElementById('empty-dashboard');
        
        if (docs.length === 0) {
            emptyState.innerHTML = '<p class="text-slate-400 font-medium">Belum ada aktivitas transaksi.</p>';
            return;
        }

        emptyState.classList.add('hidden');
        container.innerHTML = ""; // Bersihkan list

        // Ambil hanya 5 data terbaru
        const recentDocs = docs.slice(0, 5);

        recentDocs.forEach(docSnap => {
            const d = docSnap.data();
            const isPemasukan = d.jenis === 'Pemasukan';
            
            container.innerHTML += `
                <div class="flex items-center justify-between p-6 hover:bg-slate-50 rounded-[24px] border border-transparent hover:border-slate-100 transition-all group">
                    <div class="flex items-center gap-5">
                        <div class="w-12 h-12 ${isPemasukan ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600'} rounded-2xl flex items-center justify-center transition-transform group-hover:scale-110">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                ${isPemasukan 
                                    ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>' 
                                    : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/>'}
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-black text-slate-800 text-sm tracking-tight">${d.nama}</h4>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">${d.tanggal}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-black ${isPemasukan ? 'text-emerald-600' : 'text-slate-800'}">
                            ${isPemasukan ? '+' : '-'} ${formatIDR(d.nominal)}
                        </p>
                        <p class="text-[10px] font-bold text-slate-300 uppercase">${d.user.split('@')[0]}</p>
                    </div>
                </div>
            `;
        });
    }

    // --- Listen to Firestore (Real-time) ---
    function startRealtimeSync() {
        const q = query(transCollection, orderBy("created_at", "desc"));
        
        onSnapshot(q, (snapshot) => {
            updateStats(snapshot.docs);
            updateRecentList(snapshot.docs);
        });
    }

    // --- Handle User Greeting ---
    auth.onAuthStateChanged(user => {
        if (user) {
            const userName = user.displayName || user.email.split('@')[0];
            document.getElementById('user-greeting').innerText = userName.charAt(0).toUpperCase() + userName.slice(1);
            startRealtimeSync();
        }
    });

</script>
@endpush