<!-- Ultra-thin 18px Mobile Bottom Blend Gradient (Softly fades scrolling content into white before bottom bar) -->
<div class="md:hidden fixed bottom-[68px] left-0 right-0 h-[18px] pointer-events-none z-40 bg-gradient-to-t from-white via-white/60 to-transparent"></div>

<!-- ============================================================
     FIXED MOBILE NAVIGATION BAR WITH ROUTE LINKS
     Mobile & Tablet Priority Touch Target (Min 48x48px)
     ============================================================ -->
<nav id="mobileNav" class="mobile-nav-container md:hidden fixed bottom-0 left-0 right-0 z-50 bg-[#342A6E] h-[68px] flex items-center select-none shadow-[0_-4px_16px_rgba(52,42,110,0.12)]">

  <!-- 6 Mobile Navigation Buttons (Grid) - Large Touch Targets (Min 48x48px) -->
  <div class="grid grid-cols-6 w-full h-full relative z-10">
    <!-- Menu 0: Dasbor Utama -->
    <a href="{{ route('dashboard') }}" class="mobile-nav-btn min-w-[48px] min-h-[48px] py-2 flex flex-col items-center justify-center {{ request()->routeIs('dashboard') ? 'text-brandOrange font-bold' : 'text-white/70 hover:text-white' }}" title="Dasbor Utama">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <rect x="3" y="3" width="7" height="7" rx="1.5" />
        <rect x="14" y="3" width="7" height="7" rx="1.5" />
        <rect x="14" y="14" width="7" height="7" rx="1.5" />
        <rect x="3" y="14" width="7" height="7" rx="1.5" />
      </svg>
      <span class="text-[9px] mt-0.5">Dasbor</span>
    </a>

    <!-- Menu 1: Master Produk -->
    <a href="{{ route('products.index') }}" class="mobile-nav-btn min-w-[48px] min-h-[48px] py-2 flex flex-col items-center justify-center {{ request()->routeIs('products.*') ? 'text-brandOrange font-bold' : 'text-white/70 hover:text-white' }}" title="Produk">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
      </svg>
      <span class="text-[9px] mt-0.5">Produk</span>
    </a>

    <!-- Menu 2: Suplayer -->
    <a href="{{ route('suppliers.index') }}" class="mobile-nav-btn min-w-[48px] min-h-[48px] py-2 flex flex-col items-center justify-center {{ request()->routeIs('suppliers.*') ? 'text-brandOrange font-bold' : 'text-white/70 hover:text-white' }}" title="Suplayer">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
      </svg>
      <span class="text-[9px] mt-0.5">Suplayer</span>
    </a>

    <!-- Menu 3: Gudang Pusat -->
    <a href="{{ route('warehouse.index') }}" class="mobile-nav-btn min-w-[48px] min-h-[48px] py-2 flex flex-col items-center justify-center {{ request()->routeIs('warehouse.*') ? 'text-brandOrange font-bold' : 'text-white/70 hover:text-white' }}" title="Gudang">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
      </svg>
      <span class="text-[9px] mt-0.5">Gudang</span>
    </a>

    <!-- Menu 4: Kasir POS -->
    <a href="{{ route('pos.index') }}" class="mobile-nav-btn min-w-[48px] min-h-[48px] py-2 flex flex-col items-center justify-center {{ request()->routeIs('pos.*') ? 'text-brandOrange font-bold' : 'text-white/70 hover:text-white' }}" title="Kasir POS">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
      </svg>
      <span class="text-[9px] mt-0.5">Kasir POS</span>
    </a>

    <!-- Menu 5: Audit Log / Admin -->
    @if(auth()->check() && auth()->user()->isSuperAdmin())
      <a href="{{ route('admin.users') }}" class="mobile-nav-btn min-w-[48px] min-h-[48px] py-2 flex flex-col items-center justify-center {{ request()->routeIs('admin.*') ? 'text-brandOrange font-bold' : 'text-white/70 hover:text-white' }}" title="Admin">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
        </svg>
        <span class="text-[9px] mt-0.5">Admin</span>
      </a>
    @else
      <a href="{{ route('audit.index') }}" class="mobile-nav-btn min-w-[48px] min-h-[48px] py-2 flex flex-col items-center justify-center {{ request()->routeIs('audit.*') ? 'text-brandOrange font-bold' : 'text-white/70 hover:text-white' }}" title="Audit">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
        </svg>
        <span class="text-[9px] mt-0.5">Audit</span>
      </a>
    @endif
  </div>
</nav>
