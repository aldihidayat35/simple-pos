<!-- =======================================================
     PAGE 5 (INDEX 5): MASTER PRODUK, MULTI-SATUAN (UOM), & SUPLAYER
     Sistem Operasional Pasar Terpadu (Gudang, Toko, & B2B)
     ======================================================= -->
<div id="page-5" class="page-view hidden space-y-6">

  <!-- Header Banner & Action Bar -->
  <div class="bg-white rounded-[26px] p-6 border border-[#ECEBF4] flex flex-col md:flex-row items-start md:items-center justify-between gap-4 shadow-sm">
    <div>
      <div class="inline-flex items-center gap-2 bg-sidebar/10 px-3 py-1 rounded-full text-xs font-bold text-sidebar mb-2">
        <span class="w-2 h-2 rounded-full bg-sidebar"></span>
        <span data-i18n="p5_badge">Fase 3 • Master Data Pasar</span>
      </div>
      <h1 class="font-display text-2xl font-bold text-textMain" data-i18n="p5_title">
        Master Produk, Konversi Satuan & Suplayer
      </h1>
      <p class="text-xs text-textMuted mt-0.5 leading-relaxed" data-i18n="p5_subtitle">
        Pencegahan duplikasi SKU dengan analisis kemiripan teks (Fuzzy Matching $\ge 75\%$) & konversi satuan bertingkat (Karung/Dus $\rightarrow$ Kg/Pcs).
      </p>
    </div>

    <!-- Quick Action Buttons -->
    <div class="flex flex-wrap items-center gap-2.5 w-full md:w-auto">
      @isReadOnly
        <button onclick="openToast('Akses Read-Only: Role Owner hanya memantau data master dan tidak dapat menambah produk baru.')" class="min-h-[46px] px-4 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] text-textMuted text-xs font-bold transition flex items-center gap-2 cursor-not-allowed">
          <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
          <span data-i18n="p5_btn_readonly">Mode Read-Only</span>
        </button>
      @else
        <button onclick="openCreateSupplierModal()" class="min-h-[46px] px-4 py-2.5 rounded-xl bg-panelBg hover:bg-[#EAE8F2] text-sidebar text-xs font-bold transition flex items-center gap-2 border border-[#E6E4F0] active:scale-95">
          <svg class="w-4 h-4 text-sidebar" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
          </svg>
          <span data-i18n="p5_btn_add_supplier">+ Suplayer Baru</span>
        </button>

        <button onclick="openCreateProductModal()" class="min-h-[46px] px-5 py-2.5 rounded-xl bg-sidebar hover:bg-sidebarDark text-white text-xs font-bold transition flex items-center gap-2 shadow-sm active:scale-95">
          <svg class="w-4 h-4 text-brandOrange" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
          </svg>
          <span data-i18n="p5_btn_add_product">+ Tambah Produk</span>
        </button>
      @endisReadOnly
    </div>
  </div>

  <!-- Inner Tab Navigation -->
  <div class="flex items-center gap-2 border-b border-[#E6E4F0] pb-1">
    <button 
      onclick="switchProductTab('tabProducts')" 
      id="p5-tabBtn-tabProducts" 
      class="p5-tab-btn px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2 bg-sidebar text-white shadow-sm"
    >
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
      </svg>
      <span data-i18n="p5_tab_products">Katalog Master Produk ({{ $products->count() }})</span>
    </button>

    <button 
      onclick="switchProductTab('tabSuppliers')" 
      id="p5-tabBtn-tabSuppliers" 
      class="p5-tab-btn px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2 text-textMuted hover:text-textMain hover:bg-panelBg"
    >
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
      </svg>
      <span data-i18n="p5_tab_suppliers">Daftar Suplayer Resmi ({{ $suppliers->count() }})</span>
    </button>
  </div>

  <!-- ========================================================
       TAB A: MASTER PRODUK & MULTI-SATUAN
       ======================================================== -->
  <div id="tabProducts" class="p5-tab-content space-y-4">
    
    <!-- Filter & Search Tool Bar -->
    <div class="bg-white rounded-[22px] p-4 border border-[#ECEBF4] flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 shadow-sm">
      <div class="flex flex-wrap items-center gap-2">
        <span class="text-xs font-bold text-textMain" data-i18n="p5_filter_cat">Kategori:</span>
        <select id="productCategoryFilter" onchange="filterProducts()" class="px-3 py-1.5 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-semibold text-textMain outline-none focus:border-sidebar">
          <option value="" data-i18n="p5_cat_all">Semua Kategori</option>
          @foreach($categories as $cat)
            <option value="{{ $cat }}">{{ $cat }}</option>
          @endforeach
        </select>
      </div>

      <div class="relative w-full sm:w-72">
        <input 
          type="text" 
          id="productSearchInput" 
          onkeyup="filterProducts()" 
          placeholder="Cari nama, SKU, atau barcode..." 
          data-i18n-placeholder="p5_search_placeholder"
          class="w-full px-4 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-medium text-textMain placeholder-textMuted outline-none focus:border-sidebar"
        />
        <svg class="w-4 h-4 text-textMuted absolute right-3.5 top-2.5 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
      </div>
    </div>

    <!-- Product Master Table -->
    <div class="bg-white rounded-[26px] border border-[#ECEBF4] overflow-hidden shadow-sm">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="productsMasterTable">
          <thead>
            <tr class="bg-panelBg text-[11px] font-bold text-textMuted uppercase tracking-wider border-b border-[#ECEBF4]">
              <th class="py-3.5 px-5">Produk & SKU</th>
              <th class="py-3.5 px-4">Satuan & Konversi</th>
              <th class="py-3.5 px-4">Stok (Gudang / Toko)</th>
              <th class="py-3.5 px-4">HPP & Floor Price</th>
              <th class="py-3.5 px-4">Rentang Harga Pasar</th>
              <th class="py-3.5 px-4">Suplayer Utama</th>
              <th class="py-3.5 px-5 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[#F0EFF6] text-xs">
            @forelse($products as $product)
              <tr class="hover:bg-panelBg/40 transition product-row" data-category="{{ $product->category }}">
                
                <!-- Product Details -->
                <td class="py-4 px-5">
                  <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl bg-sidebar/10 text-sidebar flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                      {{ substr($product->name, 0, 2) }}
                    </div>
                    <div>
                      <p class="font-bold text-textMain product-name leading-tight">{{ $product->name }}</p>
                      <div class="flex items-center gap-2 mt-1">
                        <span class="font-mono text-[10px] text-sidebar bg-sidebar/10 px-1.5 py-0.5 rounded font-extrabold product-sku">{{ $product->sku }}</span>
                        <span class="text-[10px] font-semibold text-textMuted">{{ $product->category }}</span>
                      </div>
                    </div>
                  </div>
                </td>

                <!-- Units & Multi-UOM -->
                <td class="py-4 px-4">
                  <div class="space-y-1">
                    <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-slate-100 text-slate-800 font-bold text-[11px]">
                      <span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span>
                      <span>Dasar: {{ $product->base_uom }}</span>
                    </div>

                    @if($product->units->count() > 0)
                      <div class="flex flex-wrap gap-1 mt-1">
                        @foreach($product->units as $unit)
                          <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-50 text-blue-700 border border-blue-100" title="1 {{ $unit->uom_name }} = {{ (float)$unit->conversion_factor }} {{ $product->base_uom }}">
                            {{ $unit->uom_name }} (= {{ (float)$unit->conversion_factor }} {{ $product->base_uom }})
                          </span>
                        @endforeach
                      </div>
                    @endif
                  </div>
                </td>

                <!-- Stock Levels (Gudang & Toko) -->
                <td class="py-4 px-4 whitespace-nowrap">
                  <div class="space-y-0.5">
                    <p class="font-bold text-textMain">
                      G: <span class="text-sidebar font-semibold">{{ $product->getFormattedStock($product->stock_gudang) }}</span>
                    </p>
                    <p class="text-textMuted">
                      T: <span class="text-emerald-700 font-semibold">{{ $product->getFormattedStock($product->stock_toko) }}</span>
                    </p>
                    @if($product->isLowStock())
                      <span class="inline-block px-1.5 py-0.2 rounded bg-rose-100 text-rose-700 text-[9px] font-bold mt-0.5">Stok Menipis</span>
                    @endif
                  </div>
                </td>

                <!-- HPP & Floor Price (RBAC Protected) -->
                <td class="py-4 px-4 whitespace-nowrap">
                  @canViewHpp
                    <div class="space-y-0.5">
                      <p class="font-bold text-textMain">Rp {{ number_format($product->current_hpp, 0, ',', '.') }}</p>
                      <p class="text-[10px] text-moveOrange font-bold" title="Batas Bawah Mutlak POS">
                        Floor: Rp {{ number_format($product->getFloorPrice(), 0, ',', '.') }} (+{{ (float)$product->floor_price_margin }}%)
                      </p>
                    </div>
                  @else
                    <div class="flex items-center gap-1.5 py-0.5">
                      <svg class="w-3.5 h-3.5 text-textMuted" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                      <span class="font-mono text-xs text-textMuted font-bold">Rp ••••••••</span>
                    </div>
                    <span class="text-[9px] text-rose-600 font-semibold">Dirahasiakan</span>
                  @endcanViewHpp
                </td>

                <!-- Market Price Range (Min - Max) -->
                <td class="py-4 px-4 whitespace-nowrap">
                  <div class="space-y-0.5">
                    <p class="font-bold text-textMain">
                      Rp {{ number_format($product->min_market_price, 0, ',', '.') }}
                      <span class="text-textMuted font-normal">s/d</span>
                    </p>
                    <p class="font-bold text-sidebar">
                      Rp {{ number_format($product->max_market_price, 0, ',', '.') }}
                    </p>
                  </div>
                </td>

                <!-- Supplier -->
                <td class="py-4 px-4 text-textMain font-medium">
                  {{ $product->supplier?->name ?? 'Suplayer Umum' }}
                </td>

                <!-- Actions -->
                <td class="py-4 px-5 text-right whitespace-nowrap space-x-1.5">
                  @isReadOnly
                    <button onclick="openToast('Akses Read-Only: Role Owner tidak dapat mengedit produk.')" class="px-2.5 py-1.5 rounded-lg bg-panelBg text-textMuted font-bold text-xs cursor-not-allowed">
                      Detail
                    </button>
                  @else
                    <button 
                      onclick="openEditProductModal({{ json_encode($product) }})"
                      class="px-2.5 py-1.5 rounded-lg bg-panelBg hover:bg-[#E8E6F2] text-sidebar font-bold text-xs transition border border-[#E6E4F0]"
                    >
                      Edit
                    </button>
                  @endisReadOnly
                </td>

              </tr>
            @empty
              <tr>
                <td colspan="7" class="py-8 text-center text-textMuted" data-i18n="p5_no_products">
                  Belum ada data master produk.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>

  <!-- ========================================================
       TAB B: MASTER SUPLAYER
       ======================================================== -->
  <div id="tabSuppliers" class="p5-tab-content hidden space-y-4">
    
    <div class="bg-white rounded-[26px] border border-[#ECEBF4] overflow-hidden shadow-sm">
      <div class="p-5 border-b border-[#F0EFF6] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
          <h3 class="text-base font-bold text-textMain" data-i18n="p5_sup_title">Mitra Suplayer Terdaftar</h3>
          <p class="text-xs text-textMuted mt-0.5" data-i18n="p5_sup_subtitle">Pemasok resmi barang masuk gudang dan belanja darurat (Stok Emergency) toko</p>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="bg-panelBg text-[11px] font-bold text-textMuted uppercase tracking-wider border-b border-[#ECEBF4]">
              <th class="py-3 px-5">Suplayer & Kode</th>
              <th class="py-3 px-4">Kategori Komoditas</th>
              <th class="py-3 px-4">Kontak / Sales</th>
              <th class="py-3 px-4">Termin Bayar (TOP)</th>
              <th class="py-3 px-4">Alamat Gudang Suplayer</th>
              <th class="py-3 px-5 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[#F0EFF6] text-xs">
            @forelse($suppliers as $supplier)
              <tr class="hover:bg-panelBg/40 transition">
                <td class="py-3.5 px-5">
                  <p class="font-bold text-textMain">{{ $supplier->name }}</p>
                  <p class="font-mono text-[10px] text-sidebar font-bold">{{ $supplier->code }}</p>
                </td>
                <td class="py-3.5 px-4 font-semibold text-textMain">
                  {{ $supplier->category ?? 'Umum' }}
                </td>
                <td class="py-3.5 px-4">
                  <p class="font-semibold text-textMain">{{ $supplier->contact_person ?? '-' }}</p>
                  <p class="text-[11px] text-textMuted font-mono">{{ $supplier->phone }}</p>
                </td>
                <td class="py-3.5 px-4">
                  <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold {{ $supplier->payment_terms_days > 0 ? 'bg-purple-100 text-purple-700' : 'bg-emerald-100 text-emerald-700' }}">
                    {{ $supplier->getTermsLabel() }}
                  </span>
                </td>
                <td class="py-3.5 px-4 text-textMuted max-w-xs truncate" title="{{ $supplier->address }}">
                  {{ $supplier->address ?? '-' }}
                </td>
                <td class="py-3.5 px-5 text-right space-x-1.5">
                  @isReadOnly
                    <span class="text-xs text-textMuted font-bold">Read-Only</span>
                  @else
                    <button 
                      onclick="openEditSupplierModal({{ json_encode($supplier) }})"
                      class="px-2.5 py-1.5 rounded-lg bg-panelBg hover:bg-[#E8E6F2] text-sidebar font-bold text-xs transition border border-[#E6E4F0]"
                    >
                      Edit
                    </button>
                  @endisReadOnly
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="py-8 text-center text-textMuted">
                  Belum ada data suplayer terdaftar.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>

</div>

<!-- ========================================================
     MODAL 1: TAMBAH PRODUK BARU DENGAN REAL-TIME FUZZY MATCHING
     ======================================================== -->
<div id="createProductModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
  <div class="bg-white rounded-[26px] max-w-2xl w-full p-6 sm:p-7 border border-[#ECEBF4] shadow-2xl relative space-y-5 animate-in fade-in zoom-in-95 duration-200">
    
    <div class="flex items-center justify-between border-b border-[#F0EFF6] pb-3">
      <div>
        <div class="flex items-center gap-2">
          <span class="w-2.5 h-2.5 rounded-full bg-brandOrange"></span>
          <h3 class="text-base font-bold text-textMain" data-i18n="modal_add_product_title">Tambah Master Produk Baru</h3>
        </div>
        <p class="text-xs text-textMuted mt-0.5" data-i18n="modal_add_product_subtitle">
          Dilengkapi deteksi duplikasi otomatis berbasis Fuzzy Matching & pengaturan satuan bertingkat
        </p>
      </div>
      <button onclick="closeCreateProductModal()" class="w-8 h-8 rounded-xl bg-panelBg hover:bg-[#EAE8F2] text-textMuted flex items-center justify-center transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>

    <form method="POST" action="{{ route('products.store') }}" class="space-y-4 max-h-[75vh] overflow-y-auto pr-1">
      @csrf

      <!-- Nama Produk dengan Input Listener Fuzzy Check -->
      <div>
        <label class="block text-xs font-bold text-textMain mb-1">
          Nama Produk Lengkap <span class="text-rose-500">*</span>
        </label>
        <div class="relative">
          <input 
            type="text" 
            name="name" 
            id="createProductNameInput"
            required 
            oninput="handleFuzzyNameCheck(this.value)"
            placeholder="Contoh: Beras Anak Daro Premium 10 Kg" 
            class="w-full px-4 py-3 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar focus:bg-white text-xs font-semibold text-textMain outline-none transition"
          />
          <div id="fuzzySpinner" class="hidden absolute right-3 top-3 text-textMuted animate-spin">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
          </div>
        </div>

        <!-- Live Fuzzy Duplicate Warning Container -->
        <div id="fuzzyWarningContainer" class="hidden mt-2 p-3.5 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 space-y-2 animate-in fade-in duration-200">
          <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <span class="text-xs font-bold" id="fuzzyWarningTitle">Peringatan: Potensi Duplikasi Produk Terdeteksi!</span>
          </div>
          <p class="text-[11px] text-amber-800 leading-relaxed" id="fuzzyWarningDesc">
            Ditemukan produk dengan kemiripan nama di atas ambang kunci sistem (75%). Pastikan tidak membuat produk ganda yang membingungkan stok pasar.
          </p>
          <div id="fuzzyMatchesList" class="space-y-1.5 pt-1">
            <!-- Dynamic list of matched products -->
          </div>
        </div>

        <!-- Safe Unique Name Indicator -->
        <div id="fuzzySafeIndicator" class="hidden mt-1.5 flex items-center gap-1.5 text-[11px] font-semibold text-emerald-700">
          <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
          <span>Nama produk unik dan belum terdaftar di sistem.</span>
        </div>
      </div>

      <!-- Kategori & SKU / Barcode -->
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Kategori</label>
          <select name="category" required class="w-full px-3 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-bold text-textMain outline-none">
            @foreach($categories as $cat)
              <option value="{{ $cat }}">{{ $cat }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block text-xs font-bold text-textMain mb-1">SKU (Opsional)</label>
          <input type="text" name="sku" placeholder="Auto-generate" class="w-full px-3 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-medium text-textMain outline-none"/>
        </div>

        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Barcode 1D (Opsional)</label>
          <input type="text" name="barcode" placeholder="899..." class="w-full px-3 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-medium text-textMain outline-none"/>
        </div>
      </div>

      <!-- Satuan Dasar & Suplayer Utama -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">
            Satuan Dasar Terkecil <span class="text-rose-500">*</span>
          </label>
          <input type="text" name="base_uom" required placeholder="Contoh: Kg, Pcs, Liter, Ikat" class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-bold text-textMain outline-none"/>
          <span class="text-[10px] text-textMuted mt-0.5 block">Satuan eceran terendah yang digunakan kasir POS</span>
        </div>

        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Suplayer Pemasok Utama</label>
          <select name="supplier_id" class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-medium text-textMain outline-none">
            <option value="">-- Tanpa Suplayer Tetap --</option>
            @foreach($suppliers as $sup)
              <option value="{{ $sup->id }}">{{ $sup->name }} ({{ $sup->code }})</option>
            @endforeach
          </select>
        </div>
      </div>

      <!-- Harga: HPP, Margin Floor Price, Min & Max Price -->
      <div class="p-4 rounded-2xl bg-panelBg border border-[#ECEBF4] space-y-3">
        <span class="text-xs font-bold text-textMain uppercase tracking-wide flex items-center gap-1.5">
          <svg class="w-3.5 h-3.5 text-brandOrange" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          Struktur Harga & Kunci Floor Price
        </span>

        <div class="grid grid-cols-1 sm:grid-cols-4 gap-2.5">
          <div>
            <label class="block text-[11px] font-bold text-textMain mb-1">HPP Modal (Rp)</label>
            <input type="number" step="100" name="current_hpp" id="newProductHpp" oninput="calculateFloorPricePreview()" required placeholder="14000" class="w-full px-3 py-2 rounded-xl bg-white border border-[#E6E4F0] text-xs font-bold text-textMain outline-none"/>
          </div>

          <div>
            <label class="block text-[11px] font-bold text-textMain mb-1">Margin Floor (%)</label>
            <input type="number" step="0.5" name="floor_price_margin" id="newProductFloorMargin" oninput="calculateFloorPricePreview()" value="10" class="w-full px-3 py-2 rounded-xl bg-white border border-[#E6E4F0] text-xs font-bold text-textMain outline-none"/>
          </div>

          <div>
            <label class="block text-[11px] font-bold text-textMain mb-1">Harga Min Toko (Rp)</label>
            <input type="number" step="100" name="min_market_price" required placeholder="15500" class="w-full px-3 py-2 rounded-xl bg-white border border-[#E6E4F0] text-xs font-bold text-textMain outline-none"/>
          </div>

          <div>
            <label class="block text-[11px] font-bold text-textMain mb-1">Harga Max Toko (Rp)</label>
            <input type="number" step="100" name="max_market_price" required placeholder="17000" class="w-full px-3 py-2 rounded-xl bg-white border border-[#E6E4F0] text-xs font-bold text-textMain outline-none"/>
          </div>
        </div>

        <div class="p-2.5 rounded-xl bg-white border border-[#E6E4F0] flex items-center justify-between text-xs">
          <span class="text-textMuted">Estimasi Floor Price Kunci POS:</span>
          <span class="font-extrabold text-moveOrange" id="newProductFloorPricePreview">Rp 0</span>
        </div>
      </div>

      <!-- Konversi Satuan Bertingkat (Multi-UOM Repeater) -->
      <div class="space-y-2.5">
        <div class="flex items-center justify-between">
          <div>
            <label class="text-xs font-bold text-textMain uppercase tracking-wide">Konversi Satuan Bertingkat (Multi-UOM)</label>
            <p class="text-[10px] text-textMuted">Contoh: 1 Karung 50Kg = 50 Kg dasar, atau 1 Dus = 24 Pcs dasar</p>
          </div>
          <button type="button" onclick="addUnitRow()" class="px-3 py-1 rounded-lg bg-sidebar/10 hover:bg-sidebar hover:text-white text-sidebar text-[11px] font-bold transition">
            + Tambah Satuan
          </button>
        </div>

        <div id="unitRowsContainer" class="space-y-2">
          <!-- Populated by JavaScript -->
        </div>
      </div>

      <!-- Deskripsi Produk -->
      <div>
        <label class="block text-xs font-bold text-textMain mb-1">Catatan Tambahan (Opsional)</label>
        <textarea name="description" rows="2" placeholder="Keterangan spesifikasi komoditas pasar..." class="w-full px-3.5 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-medium text-textMain outline-none"></textarea>
      </div>

      <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-[#F0EFF6]">
        <button type="button" onclick="closeCreateProductModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-textMuted hover:bg-panelBg transition">
          Batal
        </button>
        <button type="submit" class="px-6 py-2.5 rounded-xl bg-sidebar hover:bg-sidebarDark text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm active:scale-95">
          <span>Simpan Produk</span>
        </button>
      </div>
    </form>

  </div>
</div>

<!-- ========================================================
     MODAL 2: EDIT PRODUK
     ======================================================== -->
<div id="editProductModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
  <div class="bg-white rounded-[26px] max-w-2xl w-full p-6 sm:p-7 border border-[#ECEBF4] shadow-2xl relative space-y-4 animate-in fade-in zoom-in-95 duration-200">
    <div class="flex items-center justify-between border-b border-[#F0EFF6] pb-3">
      <div>
        <h3 class="text-base font-bold text-textMain" id="editProductModalTitle">Edit Master Produk</h3>
        <p class="text-xs text-textMuted mt-0.5" id="editProductModalSubtitle">Perbarui spesifikasi produk dan satuan bertingkat</p>
      </div>
      <button onclick="closeEditProductModal()" class="w-8 h-8 rounded-xl bg-panelBg hover:bg-[#EAE8F2] text-textMuted flex items-center justify-center transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>

    <form id="editProductForm" method="POST" action="" class="space-y-4 max-h-[75vh] overflow-y-auto pr-1">
      @csrf
      @method('PUT')

      <input type="hidden" id="editProductId" name="product_id">

      <div>
        <label class="block text-xs font-bold text-textMain mb-1">Nama Produk</label>
        <input type="text" name="name" id="editProductName" required class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-semibold text-textMain outline-none"/>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Kategori</label>
          <select name="category" id="editProductCategory" required class="w-full px-3 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-bold text-textMain outline-none">
            @foreach($categories as $cat)
              <option value="{{ $cat }}">{{ $cat }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block text-xs font-bold text-textMain mb-1">SKU</label>
          <input type="text" name="sku" id="editProductSku" required class="w-full px-3 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-bold text-sidebar outline-none"/>
        </div>

        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Barcode 1D</label>
          <input type="text" name="barcode" id="editProductBarcode" class="w-full px-3 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-medium text-textMain outline-none"/>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Satuan Dasar Terkecil</label>
          <input type="text" name="base_uom" id="editProductBaseUom" required class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-bold text-textMain outline-none"/>
        </div>

        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Suplayer Pemasok</label>
          <select name="supplier_id" id="editProductSupplierId" class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-medium text-textMain outline-none">
            <option value="">-- Tanpa Suplayer Tetap --</option>
            @foreach($suppliers as $sup)
              <option value="{{ $sup->id }}">{{ $sup->name }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="p-3.5 rounded-2xl bg-panelBg border border-[#ECEBF4] grid grid-cols-1 sm:grid-cols-4 gap-2.5">
        <div>
          <label class="block text-[11px] font-bold text-textMain mb-1">HPP (Rp)</label>
          <input type="number" step="100" name="current_hpp" id="editProductHpp" required class="w-full px-3 py-2 rounded-xl bg-white border border-[#E6E4F0] text-xs font-bold text-textMain outline-none"/>
        </div>
        <div>
          <label class="block text-[11px] font-bold text-textMain mb-1">Floor Margin (%)</label>
          <input type="number" step="0.5" name="floor_price_margin" id="editProductFloorMargin" class="w-full px-3 py-2 rounded-xl bg-white border border-[#E6E4F0] text-xs font-bold text-textMain outline-none"/>
        </div>
        <div>
          <label class="block text-[11px] font-bold text-textMain mb-1">Min Price (Rp)</label>
          <input type="number" step="100" name="min_market_price" id="editProductMinPrice" required class="w-full px-3 py-2 rounded-xl bg-white border border-[#E6E4F0] text-xs font-bold text-textMain outline-none"/>
        </div>
        <div>
          <label class="block text-[11px] font-bold text-textMain mb-1">Max Price (Rp)</label>
          <input type="number" step="100" name="max_market_price" id="editProductMaxPrice" required class="w-full px-3 py-2 rounded-xl bg-white border border-[#E6E4F0] text-xs font-bold text-textMain outline-none"/>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Status Produk</label>
          <select name="is_active" id="editProductStatus" class="w-full px-3 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-bold text-textMain outline-none">
            <option value="1">Aktif (Dijual & Digudangkan)</option>
            <option value="0">Nonaktif (Diarsipkan)</option>
          </select>
        </div>
      </div>

      <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-[#F0EFF6]">
        <button type="button" onclick="closeEditProductModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-textMuted hover:bg-panelBg transition">
          Batal
        </button>
        <button type="submit" class="px-6 py-2.5 rounded-xl bg-sidebar hover:bg-sidebarDark text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm active:scale-95">
          <span>Perbarui Produk</span>
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ========================================================
     MODAL 3: TAMBAH SUPLAYER BARU
     ======================================================== -->
<div id="createSupplierModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
  <div class="bg-white rounded-[26px] max-w-lg w-full p-6 sm:p-7 border border-[#ECEBF4] shadow-2xl relative space-y-4 animate-in fade-in zoom-in-95 duration-200">
    <div class="flex items-center justify-between border-b border-[#F0EFF6] pb-3">
      <div>
        <h3 class="text-base font-bold text-textMain">Tambah Suplayer Baru</h3>
        <p class="text-xs text-textMuted mt-0.5">Pemasok bahan baku dan komoditas pasar</p>
      </div>
      <button onclick="closeCreateSupplierModal()" class="w-8 h-8 rounded-xl bg-panelBg hover:bg-[#EAE8F2] text-textMuted flex items-center justify-center transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>

    <form method="POST" action="{{ route('suppliers.store') }}" class="space-y-3.5">
      @csrf

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Nama Suplayer / PT / CV</label>
          <input type="text" name="name" required placeholder="Contoh: PT Sumber Pangan Makmur" class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-semibold text-textMain outline-none"/>
        </div>

        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Kategori Komoditas</label>
          <input type="text" name="category" placeholder="Contoh: Beras & Palawija" class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-medium text-textMain outline-none"/>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Nama Kontak / Sales</label>
          <input type="text" name="contact_person" placeholder="Pak Joko" class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-medium text-textMain outline-none"/>
        </div>

        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Nomor Telepon / WhatsApp</label>
          <input type="text" name="phone" required placeholder="0812..." class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-medium text-textMain outline-none"/>
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold text-textMain mb-1">Termin Pembayaran (TOP)</label>
        <div class="flex items-center gap-2">
          <input type="number" name="payment_terms_days" value="0" min="0" max="180" class="w-24 px-3 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-bold text-textMain outline-none"/>
          <span class="text-xs text-textMuted font-medium">Hari (Isi 0 jika pembayaran tunai/cash saat barang datang)</span>
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold text-textMain mb-1">Alamat Gudang / Kantor</label>
        <textarea name="address" rows="2" placeholder="Alamat lengkap..." class="w-full px-3.5 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-medium text-textMain outline-none"></textarea>
      </div>

      <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-[#F0EFF6]">
        <button type="button" onclick="closeCreateSupplierModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-textMuted hover:bg-panelBg transition">
          Batal
        </button>
        <button type="submit" class="px-6 py-2.5 rounded-xl bg-sidebar hover:bg-sidebarDark text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm active:scale-95">
          <span>Simpan Suplayer</span>
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ========================================================
     MODAL 4: EDIT SUPLAYER
     ======================================================== -->
<div id="editSupplierModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
  <div class="bg-white rounded-[26px] max-w-lg w-full p-6 sm:p-7 border border-[#ECEBF4] shadow-2xl relative space-y-4 animate-in fade-in zoom-in-95 duration-200">
    <div class="flex items-center justify-between border-b border-[#F0EFF6] pb-3">
      <div>
        <h3 class="text-base font-bold text-textMain">Edit Data Suplayer</h3>
        <p class="text-xs text-textMuted mt-0.5" id="editSupplierModalSubtitle">Perbarui kontak dan termin suplayer</p>
      </div>
      <button onclick="closeEditSupplierModal()" class="w-8 h-8 rounded-xl bg-panelBg hover:bg-[#EAE8F2] text-textMuted flex items-center justify-center transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>

    <form id="editSupplierForm" method="POST" action="" class="space-y-3.5">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Nama Suplayer</label>
          <input type="text" name="name" id="editSupplierName" required class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-semibold text-textMain outline-none"/>
        </div>

        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Kode Suplayer</label>
          <input type="text" name="code" id="editSupplierCode" required class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-mono font-bold text-sidebar outline-none"/>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Kontak Person</label>
          <input type="text" name="contact_person" id="editSupplierContact" class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-medium text-textMain outline-none"/>
        </div>

        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Nomor Telepon</label>
          <input type="text" name="phone" id="editSupplierPhone" required class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-medium text-textMain outline-none"/>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Termin Pembayaran (Hari)</label>
          <input type="number" name="payment_terms_days" id="editSupplierTerms" min="0" max="180" class="w-full px-3 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-bold text-textMain outline-none"/>
        </div>

        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Status</label>
          <select name="is_active" id="editSupplierStatus" class="w-full px-3 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-bold text-textMain outline-none">
            <option value="1">Aktif</option>
            <option value="0">Nonaktif</option>
          </select>
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold text-textMain mb-1">Alamat</label>
        <textarea name="address" id="editSupplierAddress" rows="2" class="w-full px-3.5 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-medium text-textMain outline-none"></textarea>
      </div>

      <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-[#F0EFF6]">
        <button type="button" onclick="closeEditSupplierModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-textMuted hover:bg-panelBg transition">
          Batal
        </button>
        <button type="submit" class="px-6 py-2.5 rounded-xl bg-sidebar hover:bg-sidebarDark text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm active:scale-95">
          <span>Perbarui Suplayer</span>
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  // Inner Tab Switcher between Products and Suppliers
  function switchProductTab(tabId) {
    document.querySelectorAll('.p5-tab-content').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.p5-tab-btn').forEach(btn => {
      btn.classList.remove('bg-sidebar', 'text-white', 'shadow-sm');
      btn.classList.add('text-textMuted');
    });

    const targetTab = document.getElementById(tabId);
    if (targetTab) targetTab.classList.remove('hidden');

    const activeBtn = document.getElementById('p5-tabBtn-' + tabId);
    if (activeBtn) {
      activeBtn.classList.remove('text-textMuted');
      activeBtn.classList.add('bg-sidebar', 'text-white', 'shadow-sm');
    }
  }

  // Filter products by category and search text
  function filterProducts() {
    const search = document.getElementById('productSearchInput').value.toLowerCase();
    const category = document.getElementById('productCategoryFilter').value;
    const rows = document.querySelectorAll('.product-row');

    rows.forEach(row => {
      const name = row.querySelector('.product-name').textContent.toLowerCase();
      const sku = row.querySelector('.product-sku').textContent.toLowerCase();
      const rowCat = row.getAttribute('data-category');

      const matchesSearch = name.includes(search) || sku.includes(search);
      const matchesCat = !category || rowCat === category;

      if (matchesSearch && matchesCat) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  }

  // Real-Time Fuzzy Duplicate Name Checker (Debounced)
  let fuzzyTimeout = null;
  function handleFuzzyNameCheck(val) {
    clearTimeout(fuzzyTimeout);
    const spinner = document.getElementById('fuzzySpinner');
    const warningContainer = document.getElementById('fuzzyWarningContainer');
    const safeIndicator = document.getElementById('fuzzySafeIndicator');
    const matchesList = document.getElementById('fuzzyMatchesList');

    if (!val || val.trim().length < 3) {
      warningContainer.classList.add('hidden');
      safeIndicator.classList.add('hidden');
      spinner.classList.add('hidden');
      return;
    }

    spinner.classList.remove('hidden');

    fuzzyTimeout = setTimeout(() => {
      fetch('{{ route("products.fuzzy-check") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json',
        },
        body: JSON.stringify({ name: val })
      })
      .then(res => res.json())
      .then(data => {
        spinner.classList.add('hidden');
        if (data.has_duplicate_risk && data.matches.length > 0) {
          safeIndicator.classList.add('hidden');
          warningContainer.classList.remove('hidden');
          
          matchesList.innerHTML = '';
          data.matches.forEach(item => {
            const card = document.createElement('div');
            card.className = 'p-2.5 rounded-xl bg-white/90 border border-amber-200 flex items-center justify-between gap-3 text-xs';
            card.innerHTML = `
              <div>
                <p class="font-bold text-textMain">${item.name}</p>
                <p class="text-[10px] text-textMuted font-mono">SKU: ${item.sku} • Kategori: ${item.category} • Satuan: ${item.base_uom}</p>
              </div>
              <div class="flex items-center gap-2 shrink-0">
                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-amber-100 text-amber-800 font-mono">
                  ${item.similarity_percent}% Mirip
                </span>
                <button type="button" onclick="useExistingProduct('${item.name}')" class="px-2.5 py-1 rounded-lg bg-sidebar text-white text-[10px] font-bold hover:bg-sidebarDark transition">
                  Pilih Eksisting
                </button>
              </div>
            `;
            matchesList.appendChild(card);
          });
        } else {
          warningContainer.classList.add('hidden');
          safeIndicator.classList.remove('hidden');
        }
      })
      .catch(err => {
        spinner.classList.add('hidden');
        console.error('Fuzzy check error:', err);
      });
    }, 300);
  }

  function useExistingProduct(name) {
    openToast('Produk eksisting dipilih: [' + name + ']. Tidak membuat SKU baru.');
    closeCreateProductModal();
  }

  function calculateFloorPricePreview() {
    const hpp = parseFloat(document.getElementById('newProductHpp').value) || 0;
    const margin = parseFloat(document.getElementById('newProductFloorMargin').value) || 0;
    const floor = Math.round(hpp * (1 + (margin / 100)));
    document.getElementById('newProductFloorPricePreview').textContent = 'Rp ' + floor.toLocaleString('id-ID');
  }

  // Dynamic Multi-UOM Tiered Units Repeater
  let unitRowCount = 0;
  function addUnitRow(uomName = '', convFactor = '', sellingPrice = '', barcode = '') {
    unitRowCount++;
    const container = document.getElementById('unitRowsContainer');
    const row = document.createElement('div');
    row.id = 'unitRow-' + unitRowCount;
    row.className = 'p-3 rounded-xl bg-panelBg border border-[#E6E4F0] grid grid-cols-1 sm:grid-cols-12 gap-2 items-center';

    row.innerHTML = `
      <div class="sm:col-span-4">
        <input type="text" name="units[${unitRowCount}][uom_name]" value="${uomName}" placeholder="Nama Satuan (cth: Dus 24Pcs)" required class="w-full px-3 py-1.5 rounded-lg bg-white border border-[#E6E4F0] text-xs font-semibold text-textMain outline-none"/>
      </div>
      <div class="sm:col-span-3">
        <input type="number" step="1" min="1" name="units[${unitRowCount}][conversion_factor]" value="${convFactor}" placeholder="Pengali Dasar (24)" required class="w-full px-3 py-1.5 rounded-lg bg-white border border-[#E6E4F0] text-xs font-bold text-textMain outline-none"/>
      </div>
      <div class="sm:col-span-3">
        <input type="number" step="500" name="units[${unitRowCount}][selling_price]" value="${sellingPrice}" placeholder="Harga Kemasan (Rp)" class="w-full px-3 py-1.5 rounded-lg bg-white border border-[#E6E4F0] text-xs font-medium text-textMain outline-none"/>
      </div>
      <div class="sm:col-span-2 flex items-center justify-end">
        <button type="button" onclick="document.getElementById('unitRow-${unitRowCount}').remove()" class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50 transition" title="Hapus Satuan">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </button>
      </div>
    `;
    container.appendChild(row);
  }

  // Modals
  function openCreateProductModal() {
    document.getElementById('createProductModal').classList.remove('hidden');
    // Seed default 1 unit row if container is empty
    const container = document.getElementById('unitRowsContainer');
    if (container.children.length === 0) {
      addUnitRow('Karung 50Kg', 50, '', '');
    }
  }
  function closeCreateProductModal() {
    document.getElementById('createProductModal').classList.add('hidden');
  }

  function openEditProductModal(product) {
    const modal = document.getElementById('editProductModal');
    const form = document.getElementById('editProductForm');
    form.action = `/products/${product.id}`;

    document.getElementById('editProductId').value = product.id;
    document.getElementById('editProductModalSubtitle').textContent = `Memperbarui SKU [${product.sku}] - ${product.name}`;
    document.getElementById('editProductName').value = product.name || '';
    document.getElementById('editProductCategory').value = product.category || '';
    document.getElementById('editProductSku').value = product.sku || '';
    document.getElementById('editProductBarcode').value = product.barcode || '';
    document.getElementById('editProductBaseUom').value = product.base_uom || '';
    document.getElementById('editProductSupplierId').value = product.supplier_id || '';
    document.getElementById('editProductHpp').value = product.current_hpp || 0;
    document.getElementById('editProductFloorMargin').value = product.floor_price_margin || 10;
    document.getElementById('editProductMinPrice').value = product.min_market_price || 0;
    document.getElementById('editProductMaxPrice').value = product.max_market_price || 0;
    document.getElementById('editProductStatus').value = product.is_active ? '1' : '0';

    modal.classList.remove('hidden');
  }
  function closeEditProductModal() {
    document.getElementById('editProductModal').classList.add('hidden');
  }

  function openCreateSupplierModal() {
    document.getElementById('createSupplierModal').classList.remove('hidden');
  }
  function closeCreateSupplierModal() {
    document.getElementById('createSupplierModal').classList.add('hidden');
  }

  function openEditSupplierModal(supplier) {
    const modal = document.getElementById('editSupplierModal');
    const form = document.getElementById('editSupplierForm');
    form.action = `/suppliers/${supplier.id}`;

    document.getElementById('editSupplierModalSubtitle').textContent = `Mengubah data suplayer [${supplier.code}]`;
    document.getElementById('editSupplierName').value = supplier.name || '';
    document.getElementById('editSupplierCode').value = supplier.code || '';
    document.getElementById('editSupplierContact').value = supplier.contact_person || '';
    document.getElementById('editSupplierPhone').value = supplier.phone || '';
    document.getElementById('editSupplierTerms').value = supplier.payment_terms_days || 0;
    document.getElementById('editSupplierStatus').value = supplier.is_active ? '1' : '0';
    document.getElementById('editSupplierAddress').value = supplier.address || '';

    modal.classList.remove('hidden');
  }
  function closeEditSupplierModal() {
    document.getElementById('editSupplierModal').classList.add('hidden');
  }
</script>
