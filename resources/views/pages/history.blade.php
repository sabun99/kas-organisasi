@extends('layouts.app')

@section('title', 'Riwayat Aktivitas — KASKU')
@section('header_title', 'History')

@section('content')
<div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div>
        <h1 class="text-4xl font-black text-slate-900 tracking-tight">Riwayat Kas</h1>
        <p class="text-slate-500 mt-2 font-medium">Laporan audit dan pencarian data transaksi terdahulu.</p>
    </div>
    
    <div class="flex flex-wrap items-center gap-4 bg-white p-3 rounded-[28px] shadow-sm border border-slate-100">
        <div class="px-4 py-2">
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Cari Data</label>
            <input type="text" id="search-input" placeholder="Nama transaksi..." class="bg-transparent outline-none text-sm font-bold text-slate-700 placeholder:text-slate-300 w-40">
        </div>
        <div class="w-px h-8 bg-slate-100 hidden md:block"></div>
        <div class="px-4 py-2">
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Mulai</label>
            <input type="date" id="start-date" class="bg-transparent outline-none text-sm font-bold text-slate-700 cursor-pointer">
        </div>
        <div class="px-4 py-2">
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Selesai</label>
            <input type="date" id="end-date" class="bg-transparent outline-none text-sm font-bold text-slate-700 cursor-pointer">
        </div>
        <button id="btn-reset" class="bg-slate-50 hover:bg-slate-100 p-3 rounded-2xl transition-all group">
            <svg class="w-5 h-5 text-slate-400 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
        </button>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-[32px] border border-slate-100 shadow-sm">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Transaksi</p>
        <h2 id="summary-total" class="text-2xl font-black text-slate-800">0</h2>
    </div>
    <div class="bg-emerald-50/50 p-6 rounded-[32px] border border-emerald-100">
        <p class="text-[10px] font-black text-emerald-600/60 uppercase tracking-widest mb-2">Pemasukan (Filter)</p>
        <h2 id="summary-in" class="text-2xl font-black text-emerald-600">Rp 0</h2>
    </div>
    <div class="bg-rose-50/50 p-6 rounded-[32px] border border-rose-100">
        <p class="text-[10px] font-black text-rose-600/60 uppercase tracking-widest mb-2">Pengeluaran (Filter)</p>
        <h2 id="summary-out" class="text-2xl font-black text-rose-600">Rp 0</h2>
    </div>
</div>

<div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="p-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Waktu Log</th>
                    <th class="p-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Transaksi</th>
                    <th class="p-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                    <th class="p-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nominal</th>
                    <th class="p-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Operator</th>
                </tr>
            </thead>
            <tbody id="history-table-body" class="divide-y divide-slate-50">
                </tbody>
        </table>
    </div>
</div>

<div id="empty-history" class="hidden flex flex-col items-center justify-center py-20">
    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
        <svg class="w-8 h-8 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
    </div>
    <p class="text-slate-400 font-bold">Tidak ada data yang cocok dengan filter Anda.</p>
</div>
@endsection

@push('scripts')
<script type="module">
    import { getFirestore, collection, onSnapshot, query, orderBy } 
    from "https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js";
    import { getAuth } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";

    const db = getFirestore();
    const transCollection = collection(db, "transaksi");
    
    let allData = [];

    // --- RENDER FUNCTION ---
    function renderTable(data) {
        const tbody = document.getElementById('history-table-body');
        let totalIn = 0;
        let totalOut = 0;
        
        tbody.innerHTML = "";
        
        data.forEach(item => {
            const isPemasukan = item.jenis === 'Pemasukan';
            if(isPemasukan) totalIn += item.nominal; else totalOut += item.nominal;

            const dateObj = new Date(item.created_at);
            const timeStr = dateObj.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

            tbody.innerHTML += `
                <tr class="hover:bg-slate-50 transition-all border-b border-slate-50/50">
                    <td class="p-6">
                        <p class="text-xs font-bold text-slate-700">${item.tanggal}</p>
                        <p class="text-[10px] text-slate-400 font-medium">${timeStr} WIB</p>
                    </td>
                    <td class="p-6">
                        <p class="text-sm font-black text-slate-800">${item.nama}</p>
                        <p class="text-[10px] text-slate-400 italic">${item.keterangan || 'Tanpa keterangan'}</p>
                    </td>
                    <td class="p-6">
                        <span class="px-3 py-1 text-[9px] font-black rounded-lg uppercase tracking-widest ${isPemasukan ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600'}">
                            ${item.jenis}
                        </span>
                    </td>
                    <td class="p-6 font-black text-sm text-slate-800">
                        Rp ${item.nominal.toLocaleString('id-ID')}
                    </td>
                    <td class="p-6">
                        <span class="text-xs font-bold text-indigo-500 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">
                            ${item.user.split('@')[0]}
                        </span>
                    </td>
                </tr>
            `;
        });

        // Update Summary
        document.getElementById('summary-total').innerText = data.length;
        document.getElementById('summary-in').innerText = `Rp ${totalIn.toLocaleString('id-ID')}`;
        document.getElementById('summary-out').innerText = `Rp ${totalOut.toLocaleString('id-ID')}`;
        document.getElementById('empty-history').classList.toggle('hidden', data.length > 0);
    }

    // --- FILTER LOGIC ---
    function applyFilters() {
        const searchTerm = document.getElementById('search-input').value.toLowerCase();
        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;

        const filtered = allData.filter(item => {
            const matchSearch = item.nama.toLowerCase().includes(searchTerm);
            const matchStart = startDate ? item.tanggal >= startDate : true;
            const matchEnd = endDate ? item.tanggal <= endDate : true;
            return matchSearch && matchStart && matchEnd;
        });

        renderTable(filtered);
    }

    // Event Listeners
    document.getElementById('search-input').addEventListener('input', applyFilters);
    document.getElementById('start-date').addEventListener('change', applyFilters);
    document.getElementById('end-date').addEventListener('change', applyFilters);
    document.getElementById('btn-reset').addEventListener('click', () => {
        document.getElementById('search-input').value = "";
        document.getElementById('start-date').value = "";
        document.getElementById('end-date').value = "";
        renderTable(allData);
    });

    // --- INITIAL FETCH ---
    const q = query(transCollection, orderBy("created_at", "desc"));
    onSnapshot(q, (snapshot) => {
        allData = snapshot.docs.map(doc => ({ id: doc.id, ...doc.data() }));
        applyFilters();
    });

</script>
@endpush