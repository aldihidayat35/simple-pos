<!-- ==========================================================
     FIXED HEADER (Clean borderless header, does not move when scrolling)
     Contains: Contextual Sub-Menus (Mobile Dropdown & Desktop Pills) + Right Profile & Language Switcher
     ========================================================== -->
<header class="shrink-0 bg-white px-4 md:px-0 py-2.5 md:py-3 flex items-center justify-between gap-3 sm:gap-4 z-30">
  
  <!-- Left Header: Mobile Hamburger Dropdown + Desktop Dynamic Pill Bar -->
  <div class="flex items-center gap-2">
    
    <!-- MOBILE ONLY: 3-Lines Hamburger Button with Animated Popup Dropdown -->
    <div class="relative md:hidden" id="mobileMenuWrapper">
      <button id="mobileMenuBtn" onclick="toggleMobileSubMenu(event)" class="min-h-[44px] flex items-center gap-2.5 px-3 py-1.5 rounded-xl bg-panelBg hover:bg-[#EAE8F2] text-sidebar transition border border-[#E6E4F0]" aria-label="Menu Sub-Modul">
        <!-- 3-Lines Hamburger Icon -->
        <svg id="hamburgerIcon" class="w-4 h-4 text-sidebar shrink-0" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <span id="mobileActiveSubMenuLabel" class="text-xs font-bold text-sidebar max-w-[130px] truncate">
          Ringkasan Operasional
        </span>
        <!-- Small chevron indicator -->
        <svg id="mobileMenuChevron" class="w-3.5 h-3.5 text-textMuted transition-transform duration-200 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
      </button>

      <!-- Mobile Sub-Menu Popup Dropdown with Animation -->
      <div id="mobileSubMenuDropdown" class="hidden absolute left-0 top-full mt-2 w-64 bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-[#E8E6F2] p-2 z-50 transform origin-top-left transition-all duration-200 scale-95 opacity-0">
        <div class="px-2.5 py-1 text-[10px] font-bold tracking-wider text-textMuted uppercase border-b border-[#F0EFF6] mb-1" data-i18n="header_sub_menu_title">
          Sub-Modul Operasional
        </div>
        <div id="mobileSubMenuList" class="flex flex-col gap-1">
          <!-- Populated dynamically by JS -->
        </div>
      </div>
    </div>

    <!-- DESKTOP ONLY: Dynamic Contextual Sub-Menu Pill Bar -->
    <div id="subMenuContainer" class="hidden md:inline-flex flex-wrap items-center gap-1 bg-panelBg p-1 rounded-xl text-[11px] font-semibold text-textMuted">
      <!-- Populated dynamically by JS based on current module -->
    </div>

  </div>

  <!-- Right Header: Language Switcher, Action Shortcuts, Notifications & Profile Avatar -->
  <div class="flex items-center justify-end gap-2 sm:gap-3 shrink-0">
    
    <!-- Instant Language Switcher (ID / EN) -->
    <div class="inline-flex items-center bg-panelBg border border-[#E6E4F0] p-0.5 rounded-xl text-xs font-bold shadow-sm" id="langSwitcherContainer">
      <button id="langBtnID" onclick="setAppLanguage('id')" class="px-2.5 py-1.5 rounded-lg transition duration-200 bg-sidebar text-white shadow-sm" title="Bahasa Indonesia">
        ID
      </button>
      <button id="langBtnEN" onclick="setAppLanguage('en')" class="px-2.5 py-1.5 rounded-lg transition duration-200 text-textMuted hover:text-textMain" title="English">
        EN
      </button>
    </div>

    <!-- Live Color Codes Quick Legend Pill (PRD Movement Color Standard) -->
    <button onclick="switchPage(4)" title="Lihat Standar 5 Indikator Warna Pergerakan" class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl bg-panelBg hover:bg-[#EAE8F2] text-sidebar transition border border-[#E6E4F0] text-xs font-bold">
      <span class="flex items-center gap-1">
        <span class="w-2 h-2 rounded-full bg-moveGreen"></span>
        <span class="w-2 h-2 rounded-full bg-moveBlue"></span>
        <span class="w-2 h-2 rounded-full bg-movePurple"></span>
        <span class="w-2 h-2 rounded-full bg-moveOrange"></span>
        <span class="w-2 h-2 rounded-full bg-moveRed"></span>
      </span>
      <span class="hidden md:inline" data-i18n="header_color_legend">Warna Pergerakan</span>
    </button>

    @if(auth()->check() && auth()->user()->isReadOnly())
      <!-- Owner Read-Only Indicator Badge -->
      <div class="hidden lg:inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-[11px] font-bold" title="Mode Pengawas: Akses Read-Only Penuh">
        <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
        <span>Read-Only</span>
      </div>
    @endif

    @if(auth()->check() && auth()->user()->isSuperAdmin())
      <!-- Super Admin Panel Link -->
      <a href="{{ route('admin.users') }}" title="Panel Super Admin (Pengguna & Konfigurasi)" class="w-9 h-9 rounded-xl flex items-center justify-center text-sidebar bg-sidebar/10 hover:bg-sidebar hover:text-white transition border border-[#E6E4F0]">
        <svg class="w-4 h-4 md:w-5 md:h-5 text-brandOrange" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
          <circle cx="12" cy="12" r="3" />
        </svg>
      </a>
    @endif

    <!-- Notification Bell with Coral Dot -->
    <button onclick="openNotificationModal()" title="Notifikasi Anomali & Peringatan Sistem" class="relative w-9 h-9 rounded-xl flex items-center justify-center text-textMain/70 hover:text-sidebar hover:bg-panelBg transition border border-transparent hover:border-[#E6E4F0]">
      <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
      </svg>
      <span class="w-2.5 h-2.5 rounded-full bg-brandCoral absolute top-1.5 right-1.5 ring-2 ring-white"></span>
    </button>

    <!-- User Profile Avatar & Role Tag (Triggers Role Switcher Modal) -->
    <button onclick="openRoleSwitcherModal()" title="Klik untuk Beralih Peran (8 Role RBAC)" class="flex items-center gap-2 pl-1 cursor-pointer transition hover:opacity-90 bg-panelBg/50 hover:bg-panelBg p-1.5 rounded-2xl border border-[#E6E4F0]">
      <div class="w-8 h-8 rounded-xl bg-sidebar text-white flex items-center justify-center font-bold text-xs uppercase shrink-0">
        {{ auth()->check() ? substr(auth()->user()->name, 0, 2) : 'OP' }}
      </div>
      <div class="hidden xl:flex flex-col text-left">
        <span class="text-xs font-bold text-textMain leading-tight">{{ auth()->user()->name ?? 'Barbara W.' }}</span>
        <span class="text-[10px] font-extrabold uppercase tracking-tight {{ auth()->check() ? auth()->user()->getRoleBadgeClass() : 'text-amber-700' }} px-1.5 py-0.2 rounded mt-0.5 self-start">
          {{ auth()->check() ? auth()->user()->getRoleLabel() : 'Owner' }}
        </span>
      </div>
      <svg class="w-3.5 h-3.5 text-textMuted ml-0.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
      </svg>
    </button>

  </div>
</header>

<!-- ========================================================
     INSTANT ROLE SWITCHER & OPERATIONAL HANDOVER MODAL
     ======================================================== -->
<div id="roleSwitcherModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
  <div class="bg-white rounded-[26px] max-w-2xl w-full p-6 sm:p-7 border border-[#ECEBF4] shadow-2xl relative space-y-5 animate-in fade-in zoom-in-95 duration-200">
    
    <!-- Modal Header -->
    <div class="flex items-center justify-between border-b border-[#F0EFF6] pb-3">
      <div>
        <div class="flex items-center gap-2">
          <span class="w-2.5 h-2.5 rounded-full bg-brandOrange"></span>
          <h3 class="text-base font-bold text-textMain">Beralih Peran Operasional (8 Role RBAC)</h3>
        </div>
        <p class="text-xs text-textMuted mt-0.5">Uji izin halaman, kerahasiaan HPP, dan mode Read-Only tanpa perlu keluar sistem berulang</p>
      </div>
      <button onclick="closeRoleSwitcherModal()" class="w-8 h-8 rounded-xl bg-panelBg hover:bg-[#EAE8F2] text-textMuted flex items-center justify-center transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>

    <!-- Active User Status Card -->
    @if(auth()->check())
      <div class="p-3.5 rounded-2xl bg-panelBg border border-[#E6E4F0] flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-sidebar text-white flex items-center justify-center font-bold text-sm">
            {{ substr(auth()->user()->name, 0, 2) }}
          </div>
          <div>
            <p class="text-xs font-bold text-textMain">Sesi Aktif: {{ auth()->user()->name }} (@ {{ auth()->user()->username }})</p>
            <p class="text-[11px] text-textMuted">
              Role: <strong class="text-sidebar">{{ auth()->user()->getRoleLabel() }}</strong> • 
              HPP & Laba: <strong class="{{ auth()->user()->canViewHpp() ? 'text-emerald-600' : 'text-rose-600' }}">{{ auth()->user()->canViewHpp() ? 'Terbuka' : 'Dirahasiakan' }}</strong> • 
              Mode: <strong class="{{ auth()->user()->isReadOnly() ? 'text-amber-600' : 'text-slate-700' }}">{{ auth()->user()->isReadOnly() ? 'Read-Only Penuh' : 'Mutasi Operasional' }}</strong>
            </p>
          </div>
        </div>
        <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold uppercase {{ auth()->user()->getRoleBadgeClass() }}">
          Aktif
        </span>
      </div>
    @endif

    <!-- 8 Role Quick Switch Options -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-80 overflow-y-auto pr-1">
      @php
        $systemRoles = [
          'SUPER_ADMIN' => ['label' => 'Super Admin', 'user' => 'admin', 'desc' => 'Akses Penuh, User Management & System Locks', 'hpp' => true, 'readonly' => false, 'badge' => 'bg-purple-100 text-purple-700'],
          'OWNER' => ['label' => 'Owner', 'user' => 'owner', 'desc' => 'Pengawas: Finansial & Anomali (Read-Only Total)', 'hpp' => true, 'readonly' => true, 'badge' => 'bg-amber-100 text-amber-700'],
          'KEPALA_TOKO' => ['label' => 'Kepala Toko', 'user' => 'kepalatoko', 'desc' => 'Operasional Toko, Penjualan Ritel & Floor Price', 'hpp' => true, 'readonly' => false, 'badge' => 'bg-blue-100 text-blue-700'],
          'KEPALA_GUDANG' => ['label' => 'Kepala Gudang', 'user' => 'kepalagudang', 'desc' => 'Penerimaan PO, Konversi UOM & Stok Emergency', 'hpp' => true, 'readonly' => false, 'badge' => 'bg-indigo-100 text-indigo-700'],
          'STAF_GUDANG' => ['label' => 'Staf Gudang', 'user' => 'stafgudang', 'desc' => 'Scan Barcode, Rak & Opname Fisik (HPP Ditutup)', 'hpp' => false, 'readonly' => false, 'badge' => 'bg-slate-100 text-slate-700'],
          'STAF_TOKO' => ['label' => 'Staf Toko', 'user' => 'staftoko', 'desc' => 'Kasir POS Kilat, Setor Kas Harian (HPP Ditutup)', 'hpp' => false, 'readonly' => false, 'badge' => 'bg-sky-100 text-sky-700'],
          'SALES' => ['label' => 'Sales', 'user' => 'sales', 'desc' => 'Order Grosir Lapangan & Plafon Mitra (HPP Ditutup)', 'hpp' => false, 'readonly' => false, 'badge' => 'bg-emerald-100 text-emerald-700'],
          'B2B' => ['label' => 'Mitra B2B', 'user' => 'b2b', 'desc' => 'Portal Mandiri Grosir & Cek Piutang (HPP Ditutup)', 'hpp' => false, 'readonly' => false, 'badge' => 'bg-teal-100 text-teal-700'],
        ];
      @endphp

      @foreach($systemRoles as $roleKey => $info)
        @php
          $isCurrent = auth()->check() && auth()->user()->role === $roleKey;
        @endphp
        <form method="POST" action="{{ route('auth.switch-role') }}">
          @csrf
          <input type="hidden" name="role" value="{{ $roleKey }}">
          <button 
            type="submit" 
            class="w-full text-left p-3.5 rounded-2xl border {{ $isCurrent ? 'border-sidebar bg-sidebar/5 ring-1 ring-sidebar' : 'border-[#ECEBF4] bg-white hover:border-sidebar hover:bg-panelBg/70' }} transition flex flex-col justify-between group"
          >
            <div class="flex items-center justify-between">
              <span class="px-2 py-0.5 rounded-lg text-[10px] font-extrabold uppercase {{ $info['badge'] }}">
                {{ $info['label'] }}
              </span>
              @if($isCurrent)
                <span class="text-[10px] font-bold text-sidebar flex items-center gap-1">
                  <svg class="w-3.5 h-3.5 text-moveGreen" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                  Aktif
                </span>
              @else
                <span class="text-[10px] font-mono text-textMuted group-hover:text-sidebar font-semibold">@ {{ $info['user'] }}</span>
              @endif
            </div>

            <p class="text-xs text-textMuted mt-2 leading-snug">{{ $info['desc'] }}</p>

            <div class="mt-2.5 pt-2 border-t border-[#F0EFF6] flex items-center justify-between text-[10px] font-semibold">
              <span class="{{ $info['hpp'] ? 'text-emerald-700' : 'text-rose-600' }}">
                HPP: {{ $info['hpp'] ? 'Buka' : 'TUTUP' }}
              </span>
              <span class="{{ $info['readonly'] ? 'text-amber-700' : 'text-sidebar' }}">
                {{ $info['readonly'] ? 'Read-Only' : 'Akses Operasional' }}
              </span>
            </div>
          </button>
        </form>
      @endforeach
    </div>

    <!-- Modal Footer Actions -->
    <div class="flex items-center justify-between pt-3 border-t border-[#F0EFF6]">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold text-rose-600 hover:bg-rose-50 transition flex items-center gap-1.5">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
          <span>Keluar Sesi (Logout)</span>
        </button>
      </form>

      <div class="flex items-center gap-2">
        @if(auth()->check() && auth()->user()->isSuperAdmin())
          <a href="{{ route('admin.users') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-sidebar bg-sidebar/10 hover:bg-sidebar hover:text-white transition">
            Kelola Pengguna
          </a>
        @endif
        <button type="button" onclick="closeRoleSwitcherModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-textMuted hover:bg-panelBg transition">
          Tutup
        </button>
      </div>
    </div>

  </div>
</div>

<script>
  function openRoleSwitcherModal() {
    const modal = document.getElementById('roleSwitcherModal');
    if (modal) modal.classList.remove('hidden');
  }
  function closeRoleSwitcherModal() {
    const modal = document.getElementById('roleSwitcherModal');
    if (modal) modal.classList.add('hidden');
  }
</script>

