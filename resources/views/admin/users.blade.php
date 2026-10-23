@extends('layouts.app')

@section('title', 'Manajemen Pengguna & Konfigurasi Sistem — Super Admin')
@section('hide_right_panel', 'true')

@section('content')
<div class="flex-1 w-full space-y-6">

  <!-- Breadcrumb & Top Bar -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2">
    <div>
      <div class="flex items-center gap-2 text-xs text-textMuted font-medium mb-1">
        <a href="{{ route('dashboard') }}" class="hover:text-sidebar transition">Dasbor</a>
        <span>/</span>
        <span class="text-sidebar font-bold">Super Admin</span>
        <span>/</span>
        <span>Manajemen Pengguna & Konfigurasi</span>
      </div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-textMain tracking-tight">
        Panel Super Admin
      </h1>
      <p class="text-xs text-textMuted mt-0.5">
        Pengaturan 8 Role Pengguna, Parameter Kunci (System Locks), dan Rekaman Forensik Audit Trail
      </p>
    </div>

    <!-- Quick Action: Return to Dashboard -->
    <div class="flex items-center gap-2.5">
      <a href="{{ route('dashboard') }}" class="min-h-[44px] px-4 py-2.5 rounded-xl bg-panelBg hover:bg-[#E8E6F2] text-sidebar text-xs font-bold transition flex items-center gap-2 border border-[#E6E4F0]">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        <span>Kembali ke Dasbor</span>
      </a>

      <button onclick="openCreateUserModal()" class="min-h-[44px] px-4 py-2.5 rounded-xl bg-sidebar hover:bg-sidebarDark text-white text-xs font-bold transition flex items-center gap-2 shadow-sm active:scale-95">
        <svg class="w-4 h-4 text-brandOrange" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        <span>+ Tambah Pengguna</span>
      </button>
    </div>
  </div>

  <!-- Session Flash Alerts -->
  @if (session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center justify-between shadow-sm">
      <div class="flex items-center gap-2.5">
        <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
          </svg>
        </div>
        <span>{{ session('success') }}</span>
      </div>
      <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>
  @endif

  @if ($errors->any())
    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium space-y-1.5 shadow-sm">
      <div class="flex items-center gap-2 font-bold text-rose-900">
        <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span>Terdapat beberapa kesalahan input:</span>
      </div>
      <ul class="list-disc list-inside pl-6 space-y-1">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Zero-Approval Architecture Banner -->
  <div class="bg-panelBg border border-[#E6E4F0] rounded-[22px] p-4 sm:p-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
    <div class="flex items-start gap-3.5">
      <div class="w-10 h-10 rounded-xl bg-sidebar text-brandOrange flex items-center justify-center shrink-0 mt-0.5">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
        </svg>
      </div>
      <div>
        <h2 class="text-xs font-bold text-textMain uppercase tracking-wide">Prinsip Mutlak PRD: Zero-Approval Policy</h2>
        <p class="text-xs text-textMuted mt-0.5 leading-relaxed">
          Sistem beroperasi tanpa antrean persetujuan berjenjang yang menghambat kelancaran pasar. Setiap akun bertanggung jawab penuh atas transaksi yang dicatat dan seluruh perubahan data terekam abadi dalam log audit forensik.
        </p>
      </div>
    </div>
    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-white border border-[#E6E4F0] text-[11px] font-bold text-sidebar shrink-0 self-start md:self-auto">
      <span class="w-2 h-2 rounded-full bg-moveGreen"></span>
      <span>8 Role Terisolasi</span>
    </div>
  </div>

  <!-- Tab Navigation Switcher -->
  <div class="flex items-center gap-2 border-b border-[#E6E4F0] pb-1">
    <button 
      onclick="switchAdminTab('usersTab')" 
      id="tabBtn-usersTab" 
      class="admin-tab-btn px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2 bg-sidebar text-white shadow-sm"
    >
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
      </svg>
      <span>Pengguna & Role ({{ $users->count() }})</span>
    </button>

    <button 
      onclick="switchAdminTab('settingsTab')" 
      id="tabBtn-settingsTab" 
      class="admin-tab-btn px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2 text-textMuted hover:text-textMain hover:bg-panelBg"
    >
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
        <circle cx="12" cy="12" r="3"/>
      </svg>
      <span>Pengunci Sistem (System Locks)</span>
    </button>

    <button 
      onclick="switchAdminTab('auditTab')" 
      id="tabBtn-auditTab" 
      class="admin-tab-btn px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2 text-textMuted hover:text-textMain hover:bg-panelBg"
    >
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
      </svg>
      <span>Audit Trail Forensik ({{ $auditLogs->count() }})</span>
    </button>
  </div>

  <!-- ========================================================
       TAB 1: MANAJEMEN PENGGUNA (8 ROLE RBAC)
       ======================================================== -->
  <div id="usersTab" class="admin-tab-content space-y-4">
    
    <div class="bg-white rounded-[26px] border border-[#ECEBF4] overflow-hidden shadow-sm">
      <div class="p-5 border-b border-[#F0EFF6] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
          <h3 class="text-base font-bold text-textMain">Daftar Akun Pengguna</h3>
          <p class="text-xs text-textMuted mt-0.5">Seluruh 8 Role operasional yang memiliki hak akses sistem terisolasi</p>
        </div>
        <div class="flex items-center gap-2">
          <input 
            type="text" 
            id="userSearchInput" 
            onkeyup="filterUserTable()" 
            placeholder="Cari nama, username, atau role..." 
            class="px-3.5 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-medium text-textMain placeholder-textMuted outline-none focus:border-sidebar w-56 sm:w-64"
          />
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="usersTable">
          <thead>
            <tr class="bg-panelBg text-[11px] font-bold text-textMuted uppercase tracking-wider border-b border-[#ECEBF4]">
              <th class="py-3 px-5">Pengguna</th>
              <th class="py-3 px-4">Role RBAC</th>
              <th class="py-3 px-4">Lokasi Operasional</th>
              <th class="py-3 px-4">Akses HPP & Laba</th>
              <th class="py-3 px-4">Mode Aksi</th>
              <th class="py-3 px-4">Status</th>
              <th class="py-3 px-5 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[#F0EFF6] text-xs">
            @forelse ($users as $user)
              <tr class="hover:bg-panelBg/40 transition user-row">
                <!-- User Details -->
                <td class="py-3.5 px-5">
                  <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-sidebar/10 text-sidebar flex items-center justify-center font-bold text-xs uppercase shrink-0">
                      {{ substr($user->name, 0, 2) }}
                    </div>
                    <div>
                      <p class="font-bold text-textMain user-name leading-tight">{{ $user->name }}</p>
                      <p class="text-[11px] text-textMuted font-mono user-username">@ {{ $user->username }}</p>
                    </div>
                  </div>
                </td>

                <!-- Role Badge -->
                <td class="py-3.5 px-4 user-role">
                  <span class="inline-block px-2.5 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-wide {{ $user->getRoleBadgeClass() }}">
                    {{ $user->getRoleLabel() }}
                  </span>
                </td>

                <!-- Location -->
                <td class="py-3.5 px-4 text-textMain font-medium">
                  <div class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-textMuted" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>{{ $user->location_id ?? 'Pusat' }}</span>
                  </div>
                </td>

                <!-- HPP Visibility -->
                <td class="py-3.5 px-4">
                  @if ($user->canViewHpp())
                    <span class="inline-flex items-center gap-1 text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md font-semibold text-[11px]">
                      <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                      Terbuka
                    </span>
                  @else
                    <span class="inline-flex items-center gap-1 text-rose-700 bg-rose-50 px-2 py-0.5 rounded-md font-semibold text-[11px]">
                      <svg class="w-3 h-3 text-rose-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                      Dirahasiakan
                    </span>
                  @endif
                </td>

                <!-- Mode Aksi (Read Only / Mutasi) -->
                <td class="py-3.5 px-4">
                  @if ($user->isReadOnly())
                    <span class="inline-flex items-center gap-1 text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md font-semibold text-[11px]">
                      <svg class="w-3 h-3 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                      Read-Only
                    </span>
                  @else
                    <span class="inline-flex items-center gap-1 text-textMain bg-slate-100 px-2 py-0.5 rounded-md font-semibold text-[11px]">
                      <svg class="w-3 h-3 text-sidebar" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                      Input & Mutasi
                    </span>
                  @endif
                </td>

                <!-- Status -->
                <td class="py-3.5 px-4">
                  @if ($user->is_active)
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700">
                      <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                      Aktif
                    </span>
                  @else
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-rose-700">
                      <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                      Nonaktif
                    </span>
                  @endif
                </td>

                <!-- Actions -->
                <td class="py-3.5 px-5 text-right space-x-1.5">
                  <button 
                    onclick="openEditUserModal({{ json_encode($user) }})"
                    class="px-2.5 py-1.5 rounded-lg bg-panelBg hover:bg-[#E8E6F2] text-sidebar font-bold text-xs transition border border-[#E6E4F0]"
                  >
                    Edit
                  </button>

                  <form method="POST" action="{{ route('auth.switch-role') }}" class="inline-block">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <button 
                      type="submit" 
                      title="Uji Tampilan Role Ini"
                      class="px-2.5 py-1.5 rounded-lg bg-sidebar/10 hover:bg-sidebar hover:text-white text-sidebar font-bold text-xs transition"
                    >
                      Uji Peran
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="py-8 text-center text-textMuted">
                  Tidak ada data pengguna ditemukan.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>

  <!-- ========================================================
       TAB 2: PARAMETER PENGUNCI SISTEM (SYSTEM LOCKS)
       ======================================================== -->
  <div id="settingsTab" class="admin-tab-content hidden space-y-6">
    
    <div class="bg-white rounded-[26px] p-6 sm:p-7 border border-[#ECEBF4] shadow-sm">
      <div class="border-b border-[#F0EFF6] pb-4 mb-6">
        <h3 class="text-lg font-bold text-textMain flex items-center gap-2">
          <svg class="w-5 h-5 text-sidebar" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
          </svg>
          Parameter Pengunci Sistem (System Locks)
        </h3>
        <p class="text-xs text-textMuted mt-1">
          Batas toleransi otomatis yang melindungi integritas bisnis pasar tanpa intervensi manual berulang.
        </p>
      </div>

      <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

          <!-- Setting 1: Floor Price Margin -->
          <div class="p-5 rounded-2xl bg-panelBg border border-[#ECEBF4] space-y-3">
            <div class="flex items-center justify-between">
              <label for="floor_price_margin_percent" class="text-xs font-bold text-textMain uppercase tracking-wide">
                Batas Minimum Floor Price Margin (%)
              </label>
              <span class="px-2 py-0.5 rounded bg-moveOrangeBg text-moveOrangeText text-[10px] font-extrabold">PRD Bagian 4.2</span>
            </div>
            <p class="text-xs text-textMuted leading-relaxed">
              Sistem menolak total transaksi kasir dan pesanan B2B jika harga jual di bawah persentase margin ini di atas HPP berjalan.
            </p>
            <div class="relative">
              <input 
                type="number" 
                step="0.1" 
                min="0" 
                max="100" 
                name="floor_price_margin_percent" 
                id="floor_price_margin_percent"
                value="{{ old('floor_price_margin_percent', \App\Models\SystemSetting::getVal('floor_price_margin_percent', '10')) }}"
                required
                class="w-full px-4 py-3 rounded-xl bg-white border border-[#E6E4F0] focus:border-sidebar text-xs font-bold text-textMain outline-none"
              />
              <span class="absolute right-4 top-3 text-xs font-bold text-textMuted">%</span>
            </div>
          </div>

          <!-- Setting 2: Fuzzy Matching Threshold -->
          <div class="p-5 rounded-2xl bg-panelBg border border-[#ECEBF4] space-y-3">
            <div class="flex items-center justify-between">
              <label for="fuzzy_matching_threshold" class="text-xs font-bold text-textMain uppercase tracking-wide">
                Ambang Batas Fuzzy Match Produk (%)
              </label>
              <span class="px-2 py-0.5 rounded bg-moveBlueBg text-moveBlueText text-[10px] font-extrabold">PRD Bagian 1.1</span>
            </div>
            <p class="text-xs text-textMuted leading-relaxed">
              Tingkat kemiripan string otomatis saat staf gudang menerima PO supplier untuk mencegah duplikasi SKU akibat beda penulisan merek/kemasan.
            </p>
            <div class="relative">
              <input 
                type="number" 
                step="1" 
                min="50" 
                max="100" 
                name="fuzzy_matching_threshold" 
                id="fuzzy_matching_threshold"
                value="{{ old('fuzzy_matching_threshold', \App\Models\SystemSetting::getVal('fuzzy_matching_threshold', '75')) }}"
                required
                class="w-full px-4 py-3 rounded-xl bg-white border border-[#E6E4F0] focus:border-sidebar text-xs font-bold text-textMain outline-none"
              />
              <span class="absolute right-4 top-3 text-xs font-bold text-textMuted">%</span>
            </div>
          </div>

          <!-- Setting 3: Default B2B Credit Limit -->
          <div class="p-5 rounded-2xl bg-panelBg border border-[#ECEBF4] space-y-3">
            <div class="flex items-center justify-between">
              <label for="default_b2b_credit_limit" class="text-xs font-bold text-textMain uppercase tracking-wide">
                Plafon Piutang B2B Default (Rp)
              </label>
              <span class="px-2 py-0.5 rounded bg-movePurpleBg text-movePurpleText text-[10px] font-extrabold">PRD Bagian 5.1</span>
            </div>
            <p class="text-xs text-textMuted leading-relaxed">
              Batas kredit standar untuk akun kemitraan B2B baru sebelum mendapatkan plafon kustom yang ditetapkan oleh manajemen.
            </p>
            <div class="relative">
              <input 
                type="number" 
                step="1000000" 
                min="0" 
                name="default_b2b_credit_limit" 
                id="default_b2b_credit_limit"
                value="{{ old('default_b2b_credit_limit', \App\Models\SystemSetting::getVal('default_b2b_credit_limit', '50000000')) }}"
                required
                class="w-full px-4 py-3 rounded-xl bg-white border border-[#E6E4F0] focus:border-sidebar text-xs font-bold text-textMain outline-none"
              />
              <span class="absolute right-4 top-3 text-xs font-bold text-textMuted">IDR</span>
            </div>
          </div>

          <!-- Setting 4: Auto Block Overdue Days -->
          <div class="p-5 rounded-2xl bg-panelBg border border-[#ECEBF4] space-y-3">
            <div class="flex items-center justify-between">
              <label for="auto_block_overdue_days" class="text-xs font-bold text-textMain uppercase tracking-wide">
                Batas Hari Blokir Otomatis Overdue
              </label>
              <span class="px-2 py-0.5 rounded bg-moveRedBg text-moveRedText text-[10px] font-extrabold">PRD Bagian 5.3</span>
            </div>
            <p class="text-xs text-textMuted leading-relaxed">
              Pesanan B2B terkunci otomatis jika mitra memiliki faktur tertunggak melampaui jumlah hari jatuh tempo yang ditentukan.
            </p>
            <div class="relative">
              <input 
                type="number" 
                step="1" 
                min="1" 
                max="365" 
                name="auto_block_overdue_days" 
                id="auto_block_overdue_days"
                value="{{ old('auto_block_overdue_days', \App\Models\SystemSetting::getVal('auto_block_overdue_days', '30')) }}"
                required
                class="w-full px-4 py-3 rounded-xl bg-white border border-[#E6E4F0] focus:border-sidebar text-xs font-bold text-textMain outline-none"
              />
              <span class="absolute right-4 top-3 text-xs font-bold text-textMuted">Hari</span>
            </div>
          </div>

        </div>

        <div class="flex items-center justify-end pt-4 border-t border-[#F0EFF6]">
          <button 
            type="submit" 
            class="min-h-[46px] px-6 py-2.5 rounded-xl bg-sidebar hover:bg-sidebarDark text-white font-bold text-xs transition flex items-center gap-2 shadow-sm active:scale-95"
          >
            <svg class="w-4 h-4 text-brandOrange" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Simpan Perubahan Pengunci Sistem</span>
          </button>
        </div>
      </form>
    </div>

  </div>

  <!-- ========================================================
       TAB 3: LOG AUDIT TRAIL FORENSIK (AUDIT LOGS)
       ======================================================== -->
  <div id="auditTab" class="admin-tab-content hidden space-y-4">
    
    <div class="bg-white rounded-[26px] border border-[#ECEBF4] overflow-hidden shadow-sm">
      <div class="p-5 border-b border-[#F0EFF6] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
          <h3 class="text-base font-bold text-textMain">Rekaman Forensik Audit Trail</h3>
          <p class="text-xs text-textMuted mt-0.5">Seluruh aksi input, modifikasi, dan switch role terekam abadi dengan snapshot data</p>
        </div>
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-bold text-sidebar">
          <span class="w-2 h-2 rounded-full bg-moveGreen animate-pulse"></span>
          <span>AuditLogger Service Aktif</span>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="bg-panelBg text-[11px] font-bold text-textMuted uppercase tracking-wider border-b border-[#ECEBF4]">
              <th class="py-3 px-5">Waktu</th>
              <th class="py-3 px-4">Operator</th>
              <th class="py-3 px-4">Aksi</th>
              <th class="py-3 px-4">Keterangan</th>
              <th class="py-3 px-4">IP & Browser</th>
              <th class="py-3 px-5 text-right">Snapshot</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[#F0EFF6] text-xs">
            @forelse ($auditLogs as $log)
              <tr class="hover:bg-panelBg/40 transition">
                <!-- Timestamp -->
                <td class="py-3 px-5 font-mono text-[11px] text-textMuted whitespace-nowrap">
                  {{ $log->created_at->format('d/m/Y H:i:s') }}
                </td>

                <!-- Operator -->
                <td class="py-3 px-4">
                  <div class="flex items-center gap-2">
                    <span class="font-bold text-textMain">{{ $log->user?->name ?? 'Sistem / Tamu' }}</span>
                    @if ($log->role)
                      <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-sidebar/10 text-sidebar font-mono">
                        {{ $log->role }}
                      </span>
                    @endif
                  </div>
                </td>

                <!-- Action Badge -->
                <td class="py-3 px-4 whitespace-nowrap">
                  <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold tracking-wide {{ $log->getActionBadgeClass() }}">
                    {{ $log->action }}
                  </span>
                </td>

                <!-- Description -->
                <td class="py-3 px-4 text-textMain max-w-xs truncate" title="{{ $log->description }}">
                  {{ $log->description }}
                </td>

                <!-- IP & User Agent -->
                <td class="py-3 px-4 text-[11px] text-textMuted font-mono whitespace-nowrap">
                  {{ $log->ip_address ?? '127.0.0.1' }}
                </td>

                <!-- Snapshot Inspector -->
                <td class="py-3 px-5 text-right">
                  <button 
                    onclick="viewAuditSnapshot({{ json_encode($log) }})"
                    class="px-2.5 py-1 rounded-lg bg-panelBg hover:bg-sidebar hover:text-white text-sidebar font-bold text-[11px] transition border border-[#E6E4F0]"
                  >
                    Inspeksi Data
                  </button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="py-8 text-center text-textMuted">
                  Belum ada log audit yang terekam.
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
     MODAL 1: TAMBAH PENGGUNA BARU
     ======================================================== -->
<div id="createUserModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
  <div class="bg-white rounded-[26px] max-w-lg w-full p-6 sm:p-7 border border-[#ECEBF4] shadow-2xl relative space-y-5 animate-in fade-in zoom-in-95 duration-200">
    <div class="flex items-center justify-between border-b border-[#F0EFF6] pb-3">
      <div>
        <h3 class="text-base font-bold text-textMain">Tambah Pengguna Baru</h3>
        <p class="text-xs text-textMuted mt-0.5">Daftarkan operator dengan salah satu dari 8 Role RBAC</p>
      </div>
      <button onclick="closeCreateUserModal()" class="w-8 h-8 rounded-xl bg-panelBg hover:bg-[#EAE8F2] text-textMuted flex items-center justify-center transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>

    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
      @csrf

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Nama Lengkap</label>
          <input type="text" name="name" required placeholder="Contoh: Rian Anggara" class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-medium text-textMain outline-none"/>
        </div>

        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Username Unik</label>
          <input type="text" name="username" required placeholder="Contoh: rian_pos" class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-medium text-textMain outline-none"/>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Email (Opsional)</label>
          <input type="email" name="email" placeholder="rian@pasarhub.id" class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-medium text-textMain outline-none"/>
        </div>

        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Kata Sandi Awal</label>
          <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-medium text-textMain outline-none"/>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Peran (Role RBAC)</label>
          <select name="role" required class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-bold text-textMain outline-none">
            @foreach ($roles as $key => $label)
              <option value="{{ $key }}">{{ $label }} ({{ $key }})</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Lokasi Operasional</label>
          <select name="location_id" required class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-bold text-textMain outline-none">
            <option value="Gudang Pusat">Gudang Pusat (Central Warehouse)</option>
            <option value="Toko Ritel">Toko Ritel (Pasar Baru)</option>
            <option value="Mobile Sales">Mobile Sales (Lapangan)</option>
            <option value="Mitra Luar">Mitra B2B Eksternal</option>
          </select>
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold text-textMain mb-1">Nomor Telepon / WhatsApp</label>
        <input type="text" name="phone" placeholder="0812-xxxx-xxxx" class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-medium text-textMain outline-none"/>
      </div>

      <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-[#F0EFF6]">
        <button type="button" onclick="closeCreateUserModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-textMuted hover:bg-panelBg transition">
          Batal
        </button>
        <button type="submit" class="px-5 py-2.5 rounded-xl bg-sidebar hover:bg-sidebarDark text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
          <span>Simpan Pengguna</span>
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ========================================================
     MODAL 2: EDIT PENGGUNA
     ======================================================== -->
<div id="editUserModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
  <div class="bg-white rounded-[26px] max-w-lg w-full p-6 sm:p-7 border border-[#ECEBF4] shadow-2xl relative space-y-5 animate-in fade-in zoom-in-95 duration-200">
    <div class="flex items-center justify-between border-b border-[#F0EFF6] pb-3">
      <div>
        <h3 class="text-base font-bold text-textMain">Perbarui Data Pengguna</h3>
        <p class="text-xs text-textMuted mt-0.5" id="editModalSubTitle">Mengubah hak akses role dan parameter status akun</p>
      </div>
      <button onclick="closeEditUserModal()" class="w-8 h-8 rounded-xl bg-panelBg hover:bg-[#EAE8F2] text-textMuted flex items-center justify-center transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>

    <form id="editUserForm" method="POST" action="" class="space-y-4">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Nama Lengkap</label>
          <input type="text" name="name" id="editUserName" required class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-medium text-textMain outline-none"/>
        </div>

        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Email</label>
          <input type="email" name="email" id="editUserEmail" class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-medium text-textMain outline-none"/>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Peran (Role RBAC)</label>
          <select name="role" id="editUserRole" required class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-bold text-textMain outline-none">
            @foreach ($roles as $key => $label)
              <option value="{{ $key }}">{{ $label }} ({{ $key }})</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Lokasi Operasional</label>
          <select name="location_id" id="editUserLocation" required class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-bold text-textMain outline-none">
            <option value="Gudang Pusat">Gudang Pusat (Central Warehouse)</option>
            <option value="Toko Ritel">Toko Ritel (Pasar Baru)</option>
            <option value="Mobile Sales">Mobile Sales (Lapangan)</option>
            <option value="Mitra Luar">Mitra B2B Eksternal</option>
          </select>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Status Akun</label>
          <select name="is_active" id="editUserStatus" required class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-bold text-textMain outline-none">
            <option value="1">Aktif (Dapat Login)</option>
            <option value="0">Nonaktif (Diblokir)</option>
          </select>
        </div>

        <div>
          <label class="block text-xs font-bold text-textMain mb-1">Ganti Password (Opsional)</label>
          <input type="password" name="password" placeholder="Kosongkan jika tidak diganti" class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-medium text-textMain outline-none"/>
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold text-textMain mb-1">Nomor Telepon / WhatsApp</label>
        <input type="text" name="phone" id="editUserPhone" class="w-full px-3.5 py-2.5 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar text-xs font-medium text-textMain outline-none"/>
      </div>

      <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-[#F0EFF6]">
        <button type="button" onclick="closeEditUserModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-textMuted hover:bg-panelBg transition">
          Batal
        </button>
        <button type="submit" class="px-5 py-2.5 rounded-xl bg-sidebar hover:bg-sidebarDark text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
          <span>Perbarui Data</span>
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ========================================================
     MODAL 3: AUDIT DATA SNAPSHOT INSPECTOR
     ======================================================== -->
<div id="auditSnapshotModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
  <div class="bg-white rounded-[26px] max-w-xl w-full p-6 sm:p-7 border border-[#ECEBF4] shadow-2xl relative space-y-4 animate-in fade-in zoom-in-95 duration-200">
    <div class="flex items-center justify-between border-b border-[#F0EFF6] pb-3">
      <div>
        <h3 class="text-base font-bold text-textMain" id="snapshotTitle">Inspeksi Snapshot Data</h3>
        <p class="text-xs text-textMuted mt-0.5" id="snapshotSubtitle">Data mutasi yang terekam forensik</p>
      </div>
      <button onclick="closeAuditSnapshotModal()" class="w-8 h-8 rounded-xl bg-panelBg hover:bg-[#EAE8F2] text-textMuted flex items-center justify-center transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>

    <!-- Inspector Payload View -->
    <div class="space-y-3">
      <div>
        <span class="text-[11px] font-bold text-textMuted uppercase">Data Baru / Nilai Snapshot:</span>
        <pre id="snapshotNewValues" class="mt-1 p-3.5 rounded-xl bg-panelBg border border-[#ECEBF4] text-[11px] font-mono text-sidebar overflow-x-auto max-h-48"></pre>
      </div>

      <div id="oldValuesContainer" class="hidden">
        <span class="text-[11px] font-bold text-textMuted uppercase">Nilai Lama (Sebelum Perubahan):</span>
        <pre id="snapshotOldValues" class="mt-1 p-3.5 rounded-xl bg-rose-50/50 border border-rose-100 text-[11px] font-mono text-rose-800 overflow-x-auto max-h-48"></pre>
      </div>
    </div>

    <div class="flex items-center justify-end pt-3 border-t border-[#F0EFF6]">
      <button onclick="closeAuditSnapshotModal()" class="px-5 py-2 rounded-xl bg-panelBg hover:bg-sidebar hover:text-white text-sidebar font-bold text-xs transition">
        Tutup Inspektor
      </button>
    </div>
  </div>
</div>

@push('scripts')
<script>
  // Tab Switcher
  function switchAdminTab(tabId) {
    document.querySelectorAll('.admin-tab-content').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.admin-tab-btn').forEach(btn => {
      btn.classList.remove('bg-sidebar', 'text-white', 'shadow-sm');
      btn.classList.add('text-textMuted');
    });

    const targetTab = document.getElementById(tabId);
    if (targetTab) {
      targetTab.classList.remove('hidden');
    }

    const activeBtn = document.getElementById('tabBtn-' + tabId);
    if (activeBtn) {
      activeBtn.classList.remove('text-textMuted');
      activeBtn.classList.add('bg-sidebar', 'text-white', 'shadow-sm');
    }
  }

  // Filter User Table
  function filterUserTable() {
    const input = document.getElementById('userSearchInput').value.toLowerCase();
    const rows = document.querySelectorAll('.user-row');

    rows.forEach(row => {
      const name = row.querySelector('.user-name').textContent.toLowerCase();
      const username = row.querySelector('.user-username').textContent.toLowerCase();
      const role = row.querySelector('.user-role').textContent.toLowerCase();

      if (name.includes(input) || username.includes(input) || role.includes(input)) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  }

  // Modal Handlers
  function openCreateUserModal() {
    document.getElementById('createUserModal').classList.remove('hidden');
  }
  function closeCreateUserModal() {
    document.getElementById('createUserModal').classList.add('hidden');
  }

  function openEditUserModal(user) {
    const modal = document.getElementById('editUserModal');
    const form = document.getElementById('editUserForm');
    
    // Update action route dynamically
    form.action = `/admin/users/${user.id}`;

    document.getElementById('editModalSubTitle').textContent = `Mengubah akun @${user.username} (${user.name})`;
    document.getElementById('editUserName').value = user.name || '';
    document.getElementById('editUserEmail').value = user.email || '';
    document.getElementById('editUserRole').value = user.role || '';
    document.getElementById('editUserLocation').value = user.location_id || 'Gudang Pusat';
    document.getElementById('editUserStatus').value = user.is_active ? '1' : '0';
    document.getElementById('editUserPhone').value = user.phone || '';

    modal.classList.remove('hidden');
  }
  function closeEditUserModal() {
    document.getElementById('editUserModal').classList.add('hidden');
  }

  function viewAuditSnapshot(log) {
    document.getElementById('snapshotTitle').textContent = `Audit #${log.id}: ${log.action}`;
    document.getElementById('snapshotSubtitle').textContent = `${log.description} (${log.created_at})`;

    const newValues = log.new_values || log.data_snapshot || {};
    document.getElementById('snapshotNewValues').textContent = JSON.stringify(newValues, null, 2);

    const oldValuesContainer = document.getElementById('oldValuesContainer');
    if (log.old_values && Object.keys(log.old_values).length > 0) {
      oldValuesContainer.classList.remove('hidden');
      document.getElementById('snapshotOldValues').textContent = JSON.stringify(log.old_values, null, 2);
    } else {
      oldValuesContainer.classList.add('hidden');
    }

    document.getElementById('auditSnapshotModal').classList.remove('hidden');
  }
  function closeAuditSnapshotModal() {
    document.getElementById('auditSnapshotModal').classList.add('hidden');
  }
</script>
@endpush
@endsection
