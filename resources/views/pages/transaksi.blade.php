@extends('layouts.app')

@section('title', 'Data Transaksi — KASKU')
@section('header_title', 'Daftar Transaksi')

@section('content')
<div id="toast-container" class="fixed top-5 right-5 z-[200] space-y-3 pointer-events-none"></div>

<div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-4xl font-black text-slate-900 tracking-tight">Semua Transaksi</h1>
        <p class="text-slate-500 mt-2 font-medium">Kelola dan pantau semua aliran kas KASKU Anda.</p>
    </div>
    <button id="btn-tambah-modal" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-4 rounded-[22px] font-bold shadow-xl shadow-indigo-100 transition-all active:scale-95 flex items-center justify-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
        Tambah Transaksi
    </button>
</div>

<div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="p-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">ID</th>
                    <th class="p-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nama Transaksi</th>
                    <th class="p-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jenis</th>
                    <th class="p-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nominal</th>
                    <th class="p-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Keterangan</th>
                    <th class="p-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tanggal</th>
                    <th class="p-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">User</th>
                    <th class="p-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="transaksi-table-body" class="divide-y divide-slate-50">
                </tbody>
        </table>
    </div>
    <div class="p-6 border-t border-slate-50 flex items-center justify-between">
        <p id="transaction-count" class="text-xs font-bold text-slate-400 uppercase tracking-widest">Memuat data...</p>
    </div>
</div>

<div id="empty-state" class="hidden flex flex-col items-center justify-center py-20 bg-white rounded-[40px] border border-dashed border-slate-200 mt-6">
    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
        <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
    </div>
    <h3 class="text-lg font-black text-slate-800">Belum Ada Transaksi</h3>
    <p class="text-slate-500 text-sm mt-1">Data yang Anda masukkan akan muncul di sini.</p>
</div>

<div id="modal-transaksi" class="fixed inset-0 z-[150] hidden flex items-center justify-center p-6">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-md"></div>
    <div id="modal-content-trans" class="bg-white/90 backdrop-blur-xl border border-white/40 w-full max-w-xl rounded-[40px] shadow-2xl relative z-20 overflow-hidden transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-10">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 id="modal-title" class="text-2xl font-black text-slate-800 tracking-tight">Tambah Transaksi</h3>
                    <p class="text-slate-500 text-sm font-medium">Lengkapi detail transaksi Anda</p>
                </div>
                <button onclick="closeModal()" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-slate-50 text-slate-400 hover:bg-rose-50 hover:text-rose-500 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form id="form-transaksi" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Nama Transaksi</label>
                        <input type="text" id="nama_transaksi" required class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-slate-700">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Jenis</label>
                        <select id="jenis_transaksi" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-slate-700">
                            <option value="Pemasukan">Pemasukan (+)</option>
                            <option value="Pengeluaran">Pengeluaran (-)</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Nominal (Rp)</label>
                        <input type="number" id="nominal" required class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-slate-700">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Tanggal</label>
                        <input type="date" id="tanggal" required class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-slate-700">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Keterangan</label>
                    <textarea id="keterangan" rows="3" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-medium text-slate-700"></textarea>
                </div>
                <button type="submit" id="btn-simpan" class="w-full py-5 bg-indigo-600 text-white rounded-[24px] font-black shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all active:scale-95">
                    Simpan Transaksi
                </button>
            </form>
        </div>
    </div>
</div>

<div id="modal-delete" class="fixed inset-0 z-[160] hidden flex items-center justify-center p-6">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-md"></div>
    <div id="modal-delete-content" class="bg-white w-full max-w-sm rounded-[40px] shadow-2xl relative z-20 overflow-hidden transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-8 text-center">
            <div class="w-20 h-20 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </div>
            <h3 class="text-2xl font-black text-slate-800 mb-2">Hapus Data?</h3>
            <p class="text-slate-500 font-medium mb-8 leading-relaxed">Tindakan ini tidak dapat dibatalkan. Apakah Anda yakin ingin menghapus transaksi ini?</p>
            <div class="flex flex-col gap-3">
                <button id="confirm-delete-btn" class="w-full py-4 bg-rose-500 text-white rounded-2xl font-bold hover:bg-rose-600 transition-all active:scale-95">Ya, Hapus Sekarang</button>
                <button onclick="closeDeleteModal()" class="w-full py-4 bg-slate-50 text-slate-500 rounded-2xl font-bold hover:bg-slate-100 transition-all">Batalkan</button>
            </div>
        </div>
    </div>
</div>

<style>
    .glass-toast {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    @keyframes toastIn {
        from { transform: translateX(120%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    .animate-toast { animation: toastIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards; }
</style>
@endsection

@push('scripts')
<script type="module">
    import { getFirestore, collection, addDoc, onSnapshot, query, orderBy, doc, deleteDoc, updateDoc } 
    from "https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js";
    import { getAuth } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";

    const db = getFirestore();
    const auth = getAuth();
    const transCollection = collection(db, "transaksi");
    
    let currentEditId = null;
    let idToDelete = null;

    // --- 1. SYSTEM NOTIFIKASI (TOAST) ---
    const showToast = (message, type = 'success') => {
        const container = document.getElementById('toast-container');
        const isSuccess = type === 'success';
        const toast = document.createElement('div');
        toast.className = `glass-toast animate-toast flex items-center p-4 min-w-[320px] rounded-[24px] pointer-events-auto transition-all duration-300`;
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
    };

    // --- 2. MODAL CONTROL (FORM) ---
    const modalForm = document.getElementById('modal-transaksi');
    const contentForm = document.getElementById('modal-content-trans');

    window.openModal = () => {
        modalForm.classList.remove('hidden');
        setTimeout(() => {
            contentForm.classList.replace('opacity-0', 'opacity-100');
            contentForm.classList.replace('scale-95', 'scale-100');
        }, 10);
    };

    window.closeModal = () => {
        contentForm.classList.replace('scale-100', 'scale-95');
        contentForm.classList.replace('opacity-100', 'opacity-0');
        setTimeout(() => modalForm.classList.add('hidden'), 300);
        document.getElementById('form-transaksi').reset();
        currentEditId = null;
        document.getElementById('modal-title').innerText = "Tambah Transaksi";
        document.getElementById('btn-simpan').innerText = "Simpan Transaksi";
    };

    document.getElementById('btn-tambah-modal').addEventListener('click', window.openModal);

    // --- 3. MODAL CONTROL (DELETE) ---
    const modalDel = document.getElementById('modal-delete');
    const contentDel = document.getElementById('modal-delete-content');

    window.closeDeleteModal = () => {
        contentDel.classList.replace('scale-100', 'scale-95');
        contentDel.classList.replace('opacity-100', 'opacity-0');
        setTimeout(() => modalDel.classList.add('hidden'), 300);
        idToDelete = null;
    };

    window.deleteRow = (id) => {
        idToDelete = id;
        modalDel.classList.remove('hidden');
        setTimeout(() => {
            contentDel.classList.replace('opacity-0', 'opacity-100');
            contentDel.classList.replace('scale-95', 'scale-100');
        }, 10);
    };

    document.getElementById('confirm-delete-btn').addEventListener('click', async () => {
        if(!idToDelete) return;
        try {
            await deleteDoc(doc(db, "transaksi", idToDelete));
            showToast("Data transaksi telah dihapus");
            closeDeleteModal();
        } catch (e) { showToast("Gagal: " + e.message, "error"); }
    });

    // --- 4. CREATE & UPDATE LOGIC ---
    document.getElementById('form-transaksi').addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn = document.getElementById('btn-simpan');
        btn.disabled = true;
        
        const payload = {
            nama: document.getElementById('nama_transaksi').value,
            jenis: document.getElementById('jenis_transaksi').value,
            nominal: parseInt(document.getElementById('nominal').value),
            tanggal: document.getElementById('tanggal').value,
            keterangan: document.getElementById('keterangan').value,
            updated_at: new Date().getTime()
        };

        try {
            if (currentEditId) {
                await updateDoc(doc(db, "transaksi", currentEditId), payload);
                showToast("Transaksi berhasil diperbarui");
            } else {
                payload.user = auth.currentUser.email;
                payload.created_at = new Date().getTime();
                await addDoc(transCollection, payload);
                showToast("Transaksi baru berhasil disimpan");
            }
            closeModal();
        } catch (e) { showToast("Error: " + e.message, "error"); }
        finally { btn.disabled = false; }
    });

    // --- 5. EDIT PREPARATION ---
    window.prepareEdit = (id, nama, jenis, nominal, tanggal, keterangan) => {
        currentEditId = id;
        document.getElementById('nama_transaksi').value = nama;
        document.getElementById('jenis_transaksi').value = jenis;
        document.getElementById('nominal').value = nominal;
        document.getElementById('tanggal').value = tanggal;
        document.getElementById('keterangan').value = keterangan;
        document.getElementById('modal-title').innerText = "Edit Transaksi";
        document.getElementById('btn-simpan').innerText = "Update Transaksi";
        window.openModal();
    };

    // --- 6. REALTIME TABLE ---
    auth.onAuthStateChanged(user => {
        if(user) {
            onSnapshot(query(transCollection, orderBy("created_at", "desc")), (snap) => {
                const tbody = document.getElementById('transaksi-table-body');
                tbody.innerHTML = "";
                snap.forEach(docSnap => {
                    const d = docSnap.data();
                    const id = docSnap.id;
                    tbody.innerHTML += `
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-6 text-[10px] font-bold text-slate-300">#${id.slice(0, 5)}</td>
                            <td class="p-6 text-sm font-extrabold text-slate-800">${d.nama}</td>
                            <td class="p-6">
                                <span class="px-4 py-1.5 ${d.jenis === 'Pemasukan' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600'} text-[10px] font-black rounded-full uppercase">
                                    ${d.jenis}
                                </span>
                            </td>
                            <td class="p-6 text-sm font-black text-slate-800">Rp ${d.nominal.toLocaleString('id-ID')}</td>
                            <td class="p-6 text-xs text-slate-500 truncate max-w-[120px]">${d.keterangan || '-'}</td>
                            <td class="p-6 text-xs font-bold text-slate-600">${d.tanggal}</td>
                            <td class="p-6 text-xs font-bold text-indigo-600">${d.user.split('@')[0]}</td>
                            <td class="p-6 text-center flex justify-center gap-2">
                                <button onclick="prepareEdit('${id}', '${d.nama}', '${d.jenis}', ${d.nominal}, '${d.tanggal}', '${d.keterangan}')" class="p-2 text-slate-300 hover:text-indigo-600 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button onclick="deleteRow('${id}')" class="p-2 text-slate-300 hover:text-rose-500 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </td>
                        </tr>`;
                });
                document.getElementById('transaction-count').innerText = `Menampilkan ${snap.size} Transaksi`;
                document.getElementById('empty-state').classList.toggle('hidden', snap.size > 0);
            });
        }
    });
</script>
@endpush