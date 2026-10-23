@extends('layouts.app')

@section('title', 'Master Suplayer — PasarHub')
@section('hide_right_panel', '1')

@section('content')
<div class="flex-1 w-full space-y-6">

  <!-- Header Banner & Action Bar -->
  <div class="bg-white rounded-[26px] p-6 border border-[#ECEBF4] flex flex-col md:flex-row items-start md:items-center justify-between gap-4 shadow-sm">
    <div>
      <div class="inline-flex items-center gap-2 bg-sidebar/10 px-3 py-1 rounded-full text-xs font-bold text-sidebar mb-2">
        <span class="w-2 h-2 rounded-full bg-sidebar"></span>
        <span>Fase 3 • Rantai Pasok Suplayer</span>
      </div>
      <h1 class="font-display text-2xl font-bold text-textMain">
        Direktori Master Suplayer Pasar
      </h1>
      <p class="text-xs text-textMuted mt-0.5 leading-relaxed">
        Pemasok resmi barang masuk gudang (PO) dan pengadaan darurat (Cash / Non-PO) toko ritel.
      </p>
    </div>

    <!-- Quick Action Buttons -->
    <div class="flex flex-wrap items-center gap-2.5 w-full md:w-auto">
      <a href="{{ route('products.index') }}" class="min-h-[46px] px-4 py-2.5 rounded-xl bg-panelBg hover:bg-[#EAE8F2] text-sidebar text-xs font-bold transition flex items-center gap-2 border border-[#E6E4F0] active:scale-95">
        <svg class="w-4 h-4 text-sidebar" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
        <span>Lihat Master Produk</span>
      </a>

      @isReadOnly
        <button onclick="openToast('Akses Read-Only: Role Owner hanya memantau data master.')" class="min-h-[46px] px-4 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] text-textMuted text-xs font-bold transition flex items-center gap-2 cursor-not-allowed">
          <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
          <span>Mode Read-Only</span>
        </button>
      @else
        <button onclick="openCreateSupplierModal()" class="min-h-[46px] px-5 py-2.5 rounded-xl bg-sidebar hover:bg-sidebarDark text-white text-xs font-bold transition flex items-center gap-2 shadow-sm active:scale-95">
          <svg class="w-4 h-4 text-brandOrange" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
          </svg>
          <span>+ Tambah Suplayer</span>
        </button>
      @endisReadOnly
    </div>
  </div>

  <!-- Search & Filter Bar -->
  <div class="bg-white rounded-[22px] p-4 border border-[#ECEBF4] flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 shadow-sm">
    <div class="flex items-center gap-2 text-xs font-bold text-textMain">
      <span>Total Terdaftar: <strong class="text-sidebar">{{ $suppliers->total() }} Suplayer</strong></span>
    </div>

    <form method="GET" action="{{ route('suppliers.index') }}" class="relative w-full sm:w-80">
      <input 
        type="text" 
        name="search"
        value="{{ request('search') }}"
        placeholder="Cari suplayer, kode, kontak, telepon..." 
        class="w-full px-4 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-medium text-textMain placeholder-textMuted outline-none focus:border-sidebar pr-9"
      />
      <button type="submit" class="absolute right-3 top-2.5 text-textMuted hover:text-sidebar">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
      </button>
    </form>
  </div>

  <!-- Suppliers Table -->
  <div class="bg-white rounded-[26px] border border-[#ECEBF4] overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-panelBg text-[11px] font-bold text-textMuted uppercase tracking-wider border-b border-[#ECEBF4]">
            <th class="py-3.5 px-5">Suplayer & Kode</th>
            <th class="py-3.5 px-4">Kategori Pasokan</th>
            <th class="py-3.5 px-4">Kontak / Sales</th>
            <th class="py-3.5 px-4">Termin Bayar (TOP)</th>
            <th class="py-3.5 px-4">Alamat Gudang / Depo</th>
            <th class="py-3.5 px-4">Produk Ditautkan</th>
            <th class="py-3.5 px-5 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-[#F0EFF6] text-xs">
          @forelse($suppliers as $supplier)
            <tr class="hover:bg-panelBg/40 transition">
              <td class="py-4 px-5">
                <p class="font-bold text-textMain text-sm">{{ $supplier->name }}</p>
                <p class="font-mono text-[10px] text-sidebar font-bold mt-0.5">{{ $supplier->code }}</p>
              </td>
              <td class="py-4 px-4 font-semibold text-textMain">
                {{ $supplier->category ?? 'Umum' }}
              </td>
              <td class="py-4 px-4">
                <p class="font-semibold text-textMain">{{ $supplier->contact_person ?? '-' }}</p>
                <p class="text-[11px] text-textMuted font-mono mt-0.5">{{ $supplier->phone }}</p>
              </td>
              <td class="py-4 px-4">
                <span class="inline-block px-2.5 py-1 rounded-md text-[10px] font-bold {{ $supplier->payment_terms_days > 0 ? 'bg-purple-100 text-purple-700 border border-purple-200' : 'bg-emerald-100 text-emerald-700 border border-emerald-200' }}">
                  {{ $supplier->getTermsLabel() }}
                </span>
              </td>
              <td class="py-4 px-4 text-textMuted max-w-xs truncate" title="{{ $supplier->address }}">
                {{ $supplier->address ?? '-' }}
              </td>
              <td class="py-4 px-4 font-bold text-sidebar">
                {{ $supplier->products_count ?? $supplier->products()->count() }} SKU
              </td>
              <td class="py-4 px-5 text-right whitespace-nowrap space-x-1.5">
                @isReadOnly
                  <span class="text-xs text-textMuted font-bold">Read-Only</span>
                @else
                  <button 
                    onclick="openEditSupplierModal({{ json_encode($supplier) }})"
                    class="px-2.5 py-1.5 rounded-lg bg-panelBg hover:bg-[#E8E6F2] text-sidebar font-bold text-xs transition border border-[#E6E4F0]"
                  >
                    Edit
                  </button>
                  <form method="POST" action="{{ route('suppliers.destroy', $supplier) }}" class="inline" onsubmit="return confirm('Nonaktifkan suplayer {{ $supplier->name }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs transition">
                      Nonaktifkan
                    </button>
                  </form>
                @endisReadOnly
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="py-12 text-center text-textMuted">
                Belum ada data suplayer terdaftar. Klik <strong>+ Tambah Suplayer</strong> untuk mendaftarkan mitra pasokan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($suppliers->hasPages())
      <div class="p-4 border-t border-[#F0EFF6]">
        {{ $suppliers->links() }}
      </div>
    @endif
  </div>

</div>

<!-- ========================================================
     MODAL 3: TAMBAH SUPLAYER
     ======================================================== -->
<div id="createSupplierModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
  <div class="bg-white rounded-[26px] max-w-lg w-full p-6 sm:p-7 border border-[#ECEBF4] shadow-2xl relative space-y-5 animate-in fade-in zoom-in-95 duration-200">
    
    <div class="flex items-center justify-between border-b border-[#F0EFF6] pb-3">
      <div class="flex items-center gap-2">
        <span class="w-2.5 h-2.5 rounded-full bg-sidebar"></span>
        <h3 class="text-base font-bold text-textMain">Tambah Master Suplayer Baru</h3>
      </div>
      <button onclick="closeCreateSupplierModal()" class="w-8 h-8 rounded-xl bg-panelBg hover:bg-[#EAE8F2] text-textMuted flex items-center justify-center transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>

    <form method="POST" action="{{ route('suppliers.store') }}" class="space-y-3.5">
      @csrf

      <div>
        <label class="block text-xs font-bold text-textMain mb-1">Nama Perusahaan / Suplayer <span class="text-rose-500">*</span></label>
        <input type="text" name="name" required placeholder="Contoh: PT Sumber Beras Nusantara" class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-bold text-textMain outline-none"/>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Kode Suplayer (Opsional)</label>
          <input type="text" name="code" placeholder="SUP-XXXX" class="w-full px-3 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-medium text-textMain outline-none"/>
        </div>
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Kategori Pasokan</label>
          <input type="text" name="category" placeholder="Beras, Minyak, Telur..." class="w-full px-3 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-medium text-textMain outline-none"/>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Nama Kontak / Sales</label>
          <input type="text" name="contact_person" placeholder="Nama PIC" class="w-full px-3 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-medium text-textMain outline-none"/>
        </div>
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Nomor Telepon / WA <span class="text-rose-500">*</span></label>
          <input type="text" name="phone" required placeholder="0812..." class="w-full px-3 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-bold text-textMain outline-none"/>
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold text-textMain mb-1">Termin Pembayaran (TOP) <span class="text-rose-500">*</span></label>
        <select name="payment_terms_days" required class="w-full px-3 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-bold text-textMain outline-none">
          <option value="0">Cash / Tunai Saat Terima</option>
          <option value="3">Tempo 3 Hari</option>
          <option value="7">Tempo 7 Hari (1 Minggu)</option>
          <option value="14">Tempo 14 Hari (2 Minggu)</option>
          <option value="30">Tempo 30 Hari (1 Bulan)</option>
        </select>
      </div>

      <div>
        <label class="block text-xs font-bold text-textMain mb-1">Alamat Gudang / Depo Suplayer</label>
        <textarea name="address" rows="2" placeholder="Alamat lengkap depo pengiriman..." class="w-full px-3 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-medium text-textMain outline-none"></textarea>
      </div>

      <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-[#F0EFF6]">
        <button type="button" onclick="closeCreateSupplierModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-textMuted hover:bg-panelBg transition">
          Batal
        </button>
        <button type="submit" class="px-5 py-2.5 rounded-xl bg-sidebar hover:bg-sidebarDark text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm active:scale-95">
          <span>Daftarkan Suplayer</span>
        </button>
      </div>
    </form>

  </div>
</div>

<!-- ========================================================
     MODAL 4: EDIT SUPLAYER
     ======================================================== -->
<div id="editSupplierModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
  <div class="bg-white rounded-[26px] max-w-lg w-full p-6 sm:p-7 border border-[#ECEBF4] shadow-2xl relative space-y-5 animate-in fade-in zoom-in-95 duration-200">
    
    <div class="flex items-center justify-between border-b border-[#F0EFF6] pb-3">
      <div class="flex items-center gap-2">
        <span class="w-2.5 h-2.5 rounded-full bg-sidebar"></span>
        <h3 class="text-base font-bold text-textMain">Edit Master Suplayer</h3>
      </div>
      <button onclick="closeEditSupplierModal()" class="w-8 h-8 rounded-xl bg-panelBg hover:bg-[#EAE8F2] text-textMuted flex items-center justify-center transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>

    <form id="editSupplierForm" method="POST" action="" class="space-y-3.5">
      @csrf
      @method('PUT')

      <div>
        <label class="block text-xs font-bold text-textMain mb-1">Nama Perusahaan / Suplayer <span class="text-rose-500">*</span></label>
        <input type="text" name="name" id="editSupplierName" required class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-bold text-textMain outline-none"/>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Kode Suplayer</label>
          <input type="text" name="code" id="editSupplierCode" required class="w-full px-3 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-mono font-bold text-textMain outline-none"/>
        </div>
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Kategori Pasokan</label>
          <input type="text" name="category" id="editSupplierCategory" class="w-full px-3 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-medium text-textMain outline-none"/>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Nama Kontak / Sales</label>
          <input type="text" name="contact_person" id="editSupplierContact" class="w-full px-3 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-medium text-textMain outline-none"/>
        </div>
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Nomor Telepon / WA <span class="text-rose-500">*</span></label>
          <input type="text" name="phone" id="editSupplierPhone" required class="w-full px-3 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-bold text-textMain outline-none"/>
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold text-textMain mb-1">Termin Pembayaran (TOP) <span class="text-rose-500">*</span></label>
        <select name="payment_terms_days" id="editSupplierTerms" required class="w-full px-3 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-bold text-textMain outline-none">
          <option value="0">Cash / Tunai Saat Terima</option>
          <option value="3">Tempo 3 Hari</option>
          <option value="7">Tempo 7 Hari (1 Minggu)</option>
          <option value="14">Tempo 14 Hari (2 Minggu)</option>
          <option value="30">Tempo 30 Hari (1 Bulan)</option>
        </select>
      </div>

      <div>
        <label class="block text-xs font-bold text-textMain mb-1">Alamat Gudang / Depo Suplayer</label>
        <textarea name="address" id="editSupplierAddress" rows="2" class="w-full px-3 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-medium text-textMain outline-none"></textarea>
      </div>

      <div class="flex items-center gap-2">
        <input type="checkbox" name="is_active" id="editSupplierIsActive" value="1" class="w-4 h-4 text-sidebar rounded"/>
        <label for="editSupplierIsActive" class="text-xs font-bold text-textMain">Suplayer Aktif</label>
      </div>

      <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-[#F0EFF6]">
        <button type="button" onclick="closeEditSupplierModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-textMuted hover:bg-panelBg transition">
          Batal
        </button>
        <button type="submit" class="px-5 py-2.5 rounded-xl bg-sidebar hover:bg-sidebarDark text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm active:scale-95">
          <span>Simpan Perubahan</span>
        </button>
      </div>
    </form>

  </div>
</div>
@endsection

@push('scripts')
<script>
  function openCreateSupplierModal() {
    document.getElementById('createSupplierModal')?.classList.remove('hidden');
  }

  function closeCreateSupplierModal() {
    document.getElementById('createSupplierModal')?.classList.add('hidden');
  }

  function openEditSupplierModal(supplier) {
    const modal = document.getElementById('editSupplierModal');
    const form = document.getElementById('editSupplierForm');
    if (!modal || !form) return;

    form.action = `/suppliers/${supplier.id}`;
    document.getElementById('editSupplierName').value = supplier.name || '';
    document.getElementById('editSupplierCode').value = supplier.code || '';
    document.getElementById('editSupplierCategory').value = supplier.category || '';
    document.getElementById('editSupplierContact').value = supplier.contact_person || '';
    document.getElementById('editSupplierPhone').value = supplier.phone || '';
    document.getElementById('editSupplierTerms').value = supplier.payment_terms_days ?? 0;
    document.getElementById('editSupplierAddress').value = supplier.address || '';
    document.getElementById('editSupplierIsActive').checked = !!supplier.is_active;

    modal.classList.remove('hidden');
  }

  function closeEditSupplierModal() {
    document.getElementById('editSupplierModal')?.classList.add('hidden');
  }
</script>
@endpush
