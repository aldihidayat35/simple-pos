<!-- ============================================================
     1. FIXED DESKTOP SIDEBAR WITH SEAMLESS ROUTE LINKS
     Sistem Operasional Pasar Terpadu (Gudang, Toko, & B2B)
     ============================================================ -->
<aside class="sidebar-container hidden md:flex md:w-[92px] h-full rounded-[26px] flex-col items-center justify-between py-7 shrink-0 bg-[#342A6E]">
  
  <!-- Brand Logo: Pasar Modern -->
  <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center cursor-pointer group">
    <div class="w-10 h-10 rounded-2xl bg-white/10 flex items-center justify-center group-hover:bg-white/20 transition">
      <svg class="w-6 h-6 text-brandOrange" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
      </svg>
    </div>
    <span class="font-display text-xs tracking-tight text-white/80 mt-1.5 font-bold">Pasar<strong class="font-extrabold text-white">Hub</strong></span>
  </a>

  <!-- Navigation Icons Wrapper (Desktop Vertical) -->
  <nav id="sidebarNav" class="relative flex flex-col items-center justify-center w-full my-auto gap-2 py-2">

    <!-- Menu 0: Dasbor Utama & Kesehatan Finansial -->
    <a href="{{ route('dashboard') }}" title="Dasbor Utama & Kesehatan Finansial" class="sidebar-btn min-h-[46px] {{ request()->routeIs('dashboard') ? 'active bg-white text-sidebar font-bold rounded-2xl w-14' : '' }}">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <rect x="3" y="3" width="7" height="7" rx="1.5" />
        <rect x="14" y="3" width="7" height="7" rx="1.5" />
        <rect x="14" y="14" width="7" height="7" rx="1.5" />
        <rect x="3" y="14" width="7" height="7" rx="1.5" />
      </svg>
    </a>

    <!-- Menu 1: Master Produk & Multi-Satuan UOM -->
    <a href="{{ route('products.index') }}" title="Master Produk, Satuan & Fuzzy Matching" class="sidebar-btn min-h-[46px] {{ request()->routeIs('products.*') ? 'active bg-white text-sidebar font-bold rounded-2xl w-14' : '' }}">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
      </svg>
    </a>

    <!-- Menu 2: Master Suplayer -->
    <a href="{{ route('suppliers.index') }}" title="Master Suplayer & Termin TOP" class="sidebar-btn min-h-[46px] {{ request()->routeIs('suppliers.*') ? 'active bg-white text-sidebar font-bold rounded-2xl w-14' : '' }}">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
      </svg>
    </a>

    <!-- Menu 3: Operasional Gudang Pusat -->
    <a href="{{ route('warehouse.index') }}" title="Operasional Gudang Pusat & PO" class="sidebar-btn min-h-[46px] {{ request()->routeIs('warehouse.*') ? 'active bg-white text-sidebar font-bold rounded-2xl w-14' : '' }}">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
      </svg>
    </a>

    <!-- Menu 4: Operasional Toko & Kasir POS -->
    <a href="{{ route('pos.index') }}" title="Operasional Toko & Kasir POS" class="sidebar-btn min-h-[46px] {{ request()->routeIs('pos.*') ? 'active bg-white text-sidebar font-bold rounded-2xl w-14' : '' }}">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
      </svg>
    </a>

    <!-- Menu 5: Kemitraan B2B & Sales -->
    <a href="{{ route('b2b.index') }}" title="Kemitraan B2B & Plafon Piutang" class="sidebar-btn min-h-[46px] {{ request()->routeIs('b2b.*') ? 'active bg-white text-sidebar font-bold rounded-2xl w-14' : '' }}">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
      </svg>
    </a>

    <!-- Menu 6: Audit Trail & Rekam Jejak -->
    <a href="{{ route('audit.index') }}" title="Audit Trail & Rekam Jejak Sistem" class="sidebar-btn relative min-h-[46px] {{ request()->routeIs('audit.*') ? 'active bg-white text-sidebar font-bold rounded-2xl w-14' : '' }}">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
      </svg>
    </a>

    @if(auth()->check() && auth()->user()->isSuperAdmin())
      <!-- Menu 7: Panel Super Admin -->
      <a href="{{ route('admin.users') }}" title="Panel Super Admin (Pengguna & Konfigurasi)" class="sidebar-btn min-h-[46px] {{ request()->routeIs('admin.*') ? 'active bg-white text-sidebar font-bold rounded-2xl w-14' : '' }}">
        <svg class="w-5 h-5 text-brandOrange" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
        </svg>
      </a>
    @endif
  </nav>

  <!-- Bottom Shift / Exit Button -->
  <form method="POST" action="{{ route('logout') }}" class="w-full flex justify-center">
    @csrf
    <button type="submit" title="Keluar / Akhiri Sesi" class="text-white/60 hover:text-white transition p-2 min-h-[48px] min-w-[48px] flex items-center justify-center rounded-xl hover:bg-white/10">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
      </svg>
    </button>
  </form>
</aside>
