@extends('layouts.app')

@section('title', 'Master Produk & Konversi Satuan — PasarHub')
@section('hide_right_panel', '1')

@section('content')
<div class="flex-1 w-full space-y-6">

  <!-- Header Banner & Action Bar -->
  <div class="bg-white rounded-[26px] p-6 border border-[#ECEBF4] flex flex-col md:flex-row items-start md:items-center justify-between gap-4 shadow-sm">
    <div>
      <div class="inline-flex items-center gap-2 bg-sidebar/10 px-3 py-1 rounded-full text-xs font-bold text-sidebar mb-2">
        <span class="w-2 h-2 rounded-full bg-sidebar"></span>
        <span data-i18n="p5_badge">Fase 3 • Master Data Pasar</span>
      </div>
      <h1 class="font-display text-2xl font-bold text-textMain" data-i18n="p5_title">
        Master Produk & Konversi Satuan Bertingkat
      </h1>
      <p class="text-xs text-textMuted mt-0.5 leading-relaxed" data-i18n="p5_subtitle">
        Pencegahan duplikasi SKU dengan analisis kemiripan teks (Fuzzy Matching ≥ 75%) & konversi satuan bertingkat (Karung/Dus → Kg/Pcs).
      </p>
    </div>

    <!-- Quick Action Buttons -->
    <div class="flex flex-wrap items-center gap-2.5 w-full md:w-auto">
      <a href="{{ route('suppliers.index') }}" class="min-h-[46px] px-4 py-2.5 rounded-xl bg-panelBg hover:bg-[#EAE8F2] text-sidebar text-xs font-bold transition flex items-center gap-2 border border-[#E6E4F0] active:scale-95">
        <svg class="w-4 h-4 text-sidebar" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
        </svg>
        <span>Kelola Suplayer</span>
      </a>

      @isReadOnly
        <button onclick="openToast('Akses Read-Only: Role Owner hanya memantau data master dan tidak dapat menambah produk baru.')" class="min-h-[46px] px-4 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] text-textMuted text-xs font-bold transition flex items-center gap-2 cursor-not-allowed">
          <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
          <span data-i18n="p5_btn_readonly">Mode Read-Only</span>
        </button>
      @else
        <button onclick="openCreateProductModal()" class="min-h-[46px] px-5 py-2.5 rounded-xl bg-sidebar hover:bg-sidebarDark text-white text-xs font-bold transition flex items-center gap-2 shadow-sm active:scale-95">
          <svg class="w-4 h-4 text-brandOrange" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
          </svg>
          <span data-i18n="p5_btn_add_product">+ Tambah Produk</span>
        </button>
      @endisReadOnly
    </div>
  </div>

  <!-- Filter & Search Tool Bar -->
  <div class="bg-white rounded-[22px] p-4 border border-[#ECEBF4] flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 shadow-sm">
    <form method="GET" action="{{ route('products.index') }}" class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
      <span class="text-xs font-bold text-textMain" data-i18n="p5_filter_cat">Kategori:</span>
      <select name="category" onchange="this.form.submit()" class="px-3 py-1.5 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-semibold text-textMain outline-none focus:border-sidebar">
        <option value="" data-i18n="p5_cat_all">Semua Kategori</option>
        @foreach($categories as $cat)
          <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
        @endforeach
      </select>
      @if(request('search'))
        <input type="hidden" name="search" value="{{ request('search') }}">
      @endif
      @if(request('category'))
        <a href="{{ route('products.index') }}" class="text-[11px] font-bold text-rose-500 hover:underline">Reset Filter</a>
      @endif
    </form>

    <form method="GET" action="{{ route('products.index') }}" class="relative w-full sm:w-80">
      @if(request('category'))
        <input type="hidden" name="category" value="{{ request('category') }}">
      @endif
      <input 
        type="text" 
        name="search"
        value="{{ request('search') }}"
        placeholder="Cari nama, SKU, atau barcode..." 
        data-i18n-placeholder="p5_search_placeholder"
        class="w-full px-4 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-medium text-textMain placeholder-textMuted outline-none focus:border-sidebar pr-9"
      />
      <button type="submit" class="absolute right-3 top-2.5 text-textMuted hover:text-sidebar">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
      </button>
    </form>
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
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-50 text-blue-700 border border-blue-100" title="1 {{ $unit->uom_name }} = {{ (float)$unit->conversion_factor }} {{ $product->base_uom }} | Barcode: {{ $unit->barcode }}">
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
                  <form method="POST" action="{{ route('products.destroy', $product) }}" class="inline" onsubmit="return confirm('Nonaktifkan produk {{ $product->name }}?')">
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
              <td colspan="7" class="py-12 text-center text-textMuted" data-i18n="p5_no_products">
                Belum ada data master produk. Klik tombol <strong>+ Tambah Produk</strong> di atas untuk mendaftarkan barang baru.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($products->hasPages())
      <div class="p-4 border-t border-[#F0EFF6]">
        {{ $products->links() }}
      </div>
    @endif
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
            oninput="handleProductNameFuzzyCheck(this.value)"
            required 
            placeholder="Contoh: Beras Anak Daro Premium 50Kg" 
            class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-semibold text-textMain outline-none"
          />
          <div id="fuzzyCheckSpinner" class="hidden absolute right-3 top-2.5">
            <span class="w-4 h-4 border-2 border-sidebar border-t-transparent rounded-full animate-spin inline-block"></span>
          </div>
        </div>
        <p class="text-[10px] text-textMuted mt-1">Sistem otomatis menganalisis kemiripan nama untuk mencegah duplikasi SKU di pasar.</p>
      </div>

      <!-- Real-Time Fuzzy Similarity Warning Alert Box -->
      <div id="fuzzyWarningBox" class="hidden p-4 rounded-2xl bg-amber-50 border border-amber-200 space-y-2.5 transition-all">
        <div class="flex items-start gap-2.5">
          <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
          </svg>
          <div class="flex-1">
            <div class="flex items-center justify-between">
              <h4 class="text-xs font-extrabold text-amber-900" id="fuzzyWarningTitle">Peringatan: Ditemukan Produk Serupa!</h4>
              <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded bg-amber-200 text-amber-900" id="fuzzySimilarityBadge">≥ 75% Cocok</span>
            </div>
            <p class="text-[11px] text-amber-800 mt-0.5 leading-relaxed">
              Produk dengan nama yang sangat mirip sudah terdaftar di sistem. Mohon gunakan SKU eksisting atau pastikan varian barang berbeda sebelum menyimpan:
            </p>
            
            <!-- List of Similar Products Found -->
            <div id="fuzzyMatchesList" class="mt-2 space-y-1.5 max-h-36 overflow-y-auto">
              <!-- Dynamically populated via JS -->
            </div>
          </div>
        </div>
      </div>

      <div id="fuzzySafeBox" class="hidden p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2">
        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        <span>Nama produk unik dan belum terdaftar di sistem.</span>
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

      <!-- Saldo Stok Awal (Gudang & Toko) -->
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Stok Awal Gudang</label>
          <input type="number" step="0.1" name="stock_gudang" value="0" class="w-full px-3 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-bold text-textMain outline-none"/>
        </div>
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Stok Awal Toko</label>
          <input type="number" step="0.1" name="stock_toko" value="0" class="w-full px-3 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-bold text-textMain outline-none"/>
        </div>
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Batas Alert Min Stok</label>
          <input type="number" step="1" name="min_stock_alert" value="10" class="w-full px-3 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-bold text-textMain outline-none"/>
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
  <div class="bg-white rounded-[26px] max-w-2xl w-full p-6 sm:p-7 border border-[#ECEBF4] shadow-2xl relative space-y-5 animate-in fade-in zoom-in-95 duration-200">
    
    <div class="flex items-center justify-between border-b border-[#F0EFF6] pb-3">
      <div>
        <h3 class="text-base font-bold text-textMain" id="editProductModalTitle">Edit Master Produk</h3>
        <p class="text-xs text-textMuted mt-0.5">Perbarui spesifikasi produk, harga pasar, dan satuan kemasan</p>
      </div>
      <button onclick="closeEditProductModal()" class="w-8 h-8 rounded-xl bg-panelBg hover:bg-[#EAE8F2] text-textMuted flex items-center justify-center transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>

    <form id="editProductForm" method="POST" action="" class="space-y-4 max-h-[75vh] overflow-y-auto pr-1">
      @csrf
      @method('PUT')

      <div>
        <label class="block text-xs font-bold text-textMain mb-1">Nama Produk <span class="text-rose-500">*</span></label>
        <input type="text" name="name" id="editProductName" required class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-semibold text-textMain outline-none"/>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Kategori</label>
          <select name="category" id="editProductCategory" required class="w-full px-3 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-bold text-textMain outline-none">
            @foreach($categories as $cat)
              <option value="{{ $cat }}">{{ $cat }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">SKU</label>
          <input type="text" name="sku" id="editProductSku" required class="w-full px-3 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-medium text-textMain outline-none"/>
        </div>
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Barcode 1D</label>
          <input type="text" name="barcode" id="editProductBarcode" class="w-full px-3 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-medium text-textMain outline-none"/>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Satuan Dasar Terkecil</label>
          <input type="text" name="base_uom" id="editProductBaseUom" required class="w-full px-3 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-bold text-textMain outline-none"/>
        </div>
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Suplayer Utama</label>
          <select name="supplier_id" id="editProductSupplier" class="w-full px-3 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-medium text-textMain outline-none">
            <option value="">-- Tanpa Suplayer Tetap --</option>
            @foreach($suppliers as $sup)
              <option value="{{ $sup->id }}">{{ $sup->name }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <!-- Pricing -->
      <div class="p-4 rounded-2xl bg-panelBg border border-[#ECEBF4] space-y-3">
        <span class="text-xs font-bold text-textMain uppercase tracking-wide">Harga & Floor Price</span>
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-2.5">
          <div>
            <label class="block text-[11px] font-bold text-textMain mb-1">HPP (Rp)</label>
            <input type="number" step="100" name="current_hpp" id="editProductHpp" required class="w-full px-3 py-1.5 rounded-xl bg-white border border-[#E6E4F0] text-xs font-bold text-textMain outline-none"/>
          </div>
          <div>
            <label class="block text-[11px] font-bold text-textMain mb-1">Margin Floor (%)</label>
            <input type="number" step="0.5" name="floor_price_margin" id="editProductFloorMargin" class="w-full px-3 py-1.5 rounded-xl bg-white border border-[#E6E4F0] text-xs font-bold text-textMain outline-none"/>
          </div>
          <div>
            <label class="block text-[11px] font-bold text-textMain mb-1">Min Price (Rp)</label>
            <input type="number" step="100" name="min_market_price" id="editProductMinPrice" required class="w-full px-3 py-1.5 rounded-xl bg-white border border-[#E6E4F0] text-xs font-bold text-textMain outline-none"/>
          </div>
          <div>
            <label class="block text-[11px] font-bold text-textMain mb-1">Max Price (Rp)</label>
            <input type="number" step="100" name="max_market_price" id="editProductMaxPrice" required class="w-full px-3 py-1.5 rounded-xl bg-white border border-[#E6E4F0] text-xs font-bold text-textMain outline-none"/>
          </div>
        </div>
      </div>

      <!-- Multi-UOM Edit Repeater -->
      <div class="space-y-2">
        <div class="flex items-center justify-between">
          <label class="text-xs font-bold text-textMain uppercase tracking-wide">Konversi Satuan Bertingkat</label>
          <button type="button" onclick="addEditUnitRow()" class="px-2.5 py-1 rounded-lg bg-sidebar/10 hover:bg-sidebar hover:text-white text-sidebar text-[11px] font-bold transition">
            + Tambah Satuan
          </button>
        </div>
        <div id="editUnitRowsContainer" class="space-y-2"></div>
      </div>

      <!-- Status Aktif -->
      <div class="flex items-center gap-2">
        <input type="checkbox" name="is_active" id="editProductIsActive" value="1" class="w-4 h-4 text-sidebar rounded"/>
        <label for="editProductIsActive" class="text-xs font-bold text-textMain">Produk Aktif untuk Transaksi</label>
      </div>

      <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-[#F0EFF6]">
        <button type="button" onclick="closeEditProductModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-textMuted hover:bg-panelBg transition">
          Batal
        </button>
        <button type="submit" class="px-6 py-2.5 rounded-xl bg-sidebar hover:bg-sidebarDark text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm active:scale-95">
          <span>Simpan Perubahan</span>
        </button>
      </div>
    </form>

  </div>
</div>
@endsection

@push('scripts')
<script>
  let fuzzyTimeout = null;
  let unitRowCount = 0;
  let editUnitRowCount = 0;

  function calculateFloorPricePreview() {
    const hpp = parseFloat(document.getElementById('newProductHpp')?.value || 0);
    const margin = parseFloat(document.getElementById('newProductFloorMargin')?.value || 0);
    const floor = Math.round(hpp * (1 + (margin / 100)));
    const preview = document.getElementById('newProductFloorPricePreview');
    if (preview) {
      preview.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(floor);
    }
  }

  function handleProductNameFuzzyCheck(name) {
    clearTimeout(fuzzyTimeout);
    const warningBox = document.getElementById('fuzzyWarningBox');
    const safeBox = document.getElementById('fuzzySafeBox');
    const spinner = document.getElementById('fuzzyCheckSpinner');
    const matchesList = document.getElementById('fuzzyMatchesList');

    if (!name || name.trim().length < 3) {
      if (warningBox) warningBox.classList.add('hidden');
      if (safeBox) safeBox.classList.add('hidden');
      if (spinner) spinner.classList.add('hidden');
      return;
    }

    if (spinner) spinner.classList.remove('hidden');

    fuzzyTimeout = setTimeout(() => {
      fetch("{{ route('products.fuzzy-check') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ name: name.trim() })
      })
      .then(res => res.json())
      .then(data => {
        if (spinner) spinner.classList.add('hidden');

        if (data.has_duplicate_risk && data.matches && data.matches.length > 0) {
          if (warningBox) warningBox.classList.remove('hidden');
          if (safeBox) safeBox.classList.add('hidden');

          const badge = document.getElementById('fuzzySimilarityBadge');
          if (badge) badge.innerText = `${data.highest_similarity}% Cocok`;

          if (matchesList) {
            matchesList.innerHTML = data.matches.map(p => `
              <div class="flex items-center justify-between p-2 rounded-xl bg-white border border-amber-200 text-xs shadow-xs">
                <div>
                  <div class="flex items-center gap-1.5">
                    <span class="font-bold text-textMain">${p.name}</span>
                    <span class="text-[10px] font-mono text-sidebar font-bold bg-sidebar/10 px-1 rounded">${p.sku}</span>
                  </div>
                  <span class="text-[10px] text-textMuted">${p.category} • Stok: ${p.total_stock} ${p.base_uom}</span>
                </div>
                <div class="text-right">
                  <span class="text-[11px] font-black text-amber-700">${p.similarity_percent}%</span>
                  <button type="button" onclick="selectExistingProduct('${p.sku}', '${p.name}')" class="block text-[10px] font-bold text-sidebar hover:underline mt-0.5">Pilih Eksisting</button>
                </div>
              </div>
            `).join('');
          }
        } else {
          if (warningBox) warningBox.classList.add('hidden');
          if (safeBox) safeBox.classList.remove('hidden');
        }
      })
      .catch(err => {
        if (spinner) spinner.classList.add('hidden');
        console.error("Fuzzy check error:", err);
      });
    }, 300);
  }

  function selectExistingProduct(sku, name) {
    closeCreateProductModal();
    const search = document.querySelector('input[name="search"]');
    if (search) {
      search.value = sku;
      search.form?.submit();
    }
  }

  function addUnitRow(data = null) {
    unitRowCount++;
    const container = document.getElementById('unitRowsContainer');
    if (!container) return;

    const row = document.createElement('div');
    row.className = "p-3 rounded-xl bg-panelBg border border-[#E6E4F0] flex flex-col sm:flex-row items-center gap-2 text-xs";
    row.id = `unitRow_${unitRowCount}`;
    row.innerHTML = `
      <div class="w-full sm:w-1/3">
        <input type="text" name="units[${unitRowCount}][uom_name]" required placeholder="Nama Satuan (cth: Karung 50Kg)" value="${data?.uom_name || ''}" class="w-full px-2.5 py-1.5 rounded-lg bg-white border border-[#E6E4F0] text-xs font-semibold text-textMain outline-none"/>
      </div>
      <div class="w-full sm:w-1/4">
        <input type="number" step="0.01" name="units[${unitRowCount}][conversion_factor]" required placeholder="Faktor Isi (cth: 50)" value="${data?.conversion_factor || ''}" class="w-full px-2.5 py-1.5 rounded-lg bg-white border border-[#E6E4F0] text-xs font-semibold text-textMain outline-none"/>
      </div>
      <div class="w-full sm:w-1/4">
        <input type="number" step="100" name="units[${unitRowCount}][selling_price]" placeholder="Harga Satuan (Rp)" value="${data?.selling_price || ''}" class="w-full px-2.5 py-1.5 rounded-lg bg-white border border-[#E6E4F0] text-xs font-bold text-textMain outline-none"/>
      </div>
      <div class="w-full sm:w-auto flex items-center gap-1.5">
        <input type="text" name="units[${unitRowCount}][barcode]" placeholder="Barcode (Opsional)" value="${data?.barcode || ''}" class="w-full px-2.5 py-1.5 rounded-lg bg-white border border-[#E6E4F0] text-xs font-mono text-textMain outline-none"/>
        <button type="button" onclick="document.getElementById('unitRow_${unitRowCount}').remove()" class="p-1.5 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </button>
      </div>
    `;
    container.appendChild(row);
  }

  function addEditUnitRow(data = null) {
    editUnitRowCount++;
    const container = document.getElementById('editUnitRowsContainer');
    if (!container) return;

    const row = document.createElement('div');
    row.className = "p-3 rounded-xl bg-panelBg border border-[#E6E4F0] flex flex-col sm:flex-row items-center gap-2 text-xs";
    row.id = `editUnitRow_${editUnitRowCount}`;
    row.innerHTML = `
      <div class="w-full sm:w-1/3">
        <input type="text" name="units[${editUnitRowCount}][uom_name]" required placeholder="Nama Satuan" value="${data?.uom_name || ''}" class="w-full px-2.5 py-1.5 rounded-lg bg-white border border-[#E6E4F0] text-xs font-semibold text-textMain outline-none"/>
      </div>
      <div class="w-full sm:w-1/4">
        <input type="number" step="0.01" name="units[${editUnitRowCount}][conversion_factor]" required placeholder="Faktor Isi" value="${data?.conversion_factor || ''}" class="w-full px-2.5 py-1.5 rounded-lg bg-white border border-[#E6E4F0] text-xs font-semibold text-textMain outline-none"/>
      </div>
      <div class="w-full sm:w-1/4">
        <input type="number" step="100" name="units[${editUnitRowCount}][selling_price]" placeholder="Harga Satuan (Rp)" value="${data?.selling_price || ''}" class="w-full px-2.5 py-1.5 rounded-lg bg-white border border-[#E6E4F0] text-xs font-bold text-textMain outline-none"/>
      </div>
      <div class="w-full sm:w-auto flex items-center gap-1.5">
        <input type="text" name="units[${editUnitRowCount}][barcode]" placeholder="Barcode" value="${data?.barcode || ''}" class="w-full px-2.5 py-1.5 rounded-lg bg-white border border-[#E6E4F0] text-xs font-mono text-textMain outline-none"/>
        <button type="button" onclick="document.getElementById('editUnitRow_${editUnitRowCount}').remove()" class="p-1.5 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </button>
      </div>
    `;
    container.appendChild(row);
  }

  function openCreateProductModal() {
    document.getElementById('createProductModal')?.classList.remove('hidden');
    calculateFloorPricePreview();
  }

  function closeCreateProductModal() {
    document.getElementById('createProductModal')?.classList.add('hidden');
    document.getElementById('fuzzyWarningBox')?.classList.add('hidden');
    document.getElementById('fuzzySafeBox')?.classList.add('hidden');
  }

  function openEditProductModal(product) {
    const modal = document.getElementById('editProductModal');
    const form = document.getElementById('editProductForm');
    if (!modal || !form) return;

    form.action = `/products/${product.id}`;
    document.getElementById('editProductName').value = product.name || '';
    document.getElementById('editProductCategory').value = product.category || '';
    document.getElementById('editProductSku').value = product.sku || '';
    document.getElementById('editProductBarcode').value = product.barcode || '';
    document.getElementById('editProductBaseUom').value = product.base_uom || '';
    document.getElementById('editProductSupplier').value = product.supplier_id || '';
    document.getElementById('editProductHpp').value = product.current_hpp || 0;
    document.getElementById('editProductFloorMargin').value = product.floor_price_margin || 10;
    document.getElementById('editProductMinPrice').value = product.min_market_price || 0;
    document.getElementById('editProductMaxPrice').value = product.max_market_price || 0;
    document.getElementById('editProductIsActive').checked = !!product.is_active;

    const unitContainer = document.getElementById('editUnitRowsContainer');
    if (unitContainer) {
      unitContainer.innerHTML = '';
      if (product.units && product.units.length > 0) {
        product.units.forEach(u => addEditUnitRow(u));
      }
    }

    modal.classList.remove('hidden');
  }

  function closeEditProductModal() {
    document.getElementById('editProductModal')?.classList.add('hidden');
  }
</script>
@endpush
