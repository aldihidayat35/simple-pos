@extends('layouts.app')

@section('title', 'PasarHub — Sistem Manajemen Operasional Pasar Terpadu (Gudang, Toko, & B2B)')

@section('content')
<!-- LEFT / CENTER DYNAMIC CONTENT AREA -->
<main class="flex-1 w-full space-y-6">

  <!-- 1. SOFT SOLID ORANGE HERO BANNER (Mobile & Tablet Priority) -->
  <div class="relative bg-brandOrange rounded-[26px] p-6 sm:p-8 text-white overflow-hidden flex flex-col md:flex-row items-start md:items-center justify-between gap-6 shadow-sm">
    <div class="relative z-10 max-w-xl">
      <div class="flex flex-wrap items-center gap-2 mb-3">
        <div class="inline-flex items-center gap-2 bg-white/20 px-3 py-1 rounded-full text-xs font-semibold">
          <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
          <span data-i18n="hero_live_badge">Sistem Operasional Pasar Terpadu • Real-Time</span>
        </div>
        @if(auth()->check())
          <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold uppercase tracking-wide {{ auth()->user()->getRoleBadgeClass() }}">
            {{ auth()->user()->getRoleLabel() }}
          </span>
          @if(auth()->user()->isReadOnly())
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wide bg-amber-500 text-white flex items-center gap-1">
              <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
              Read-Only
            </span>
          @endif
        @endif
      </div>
      <h1 class="font-display text-2xl sm:text-[32px] font-bold tracking-tight leading-tight">
        Halo, {{ auth()->user()->name ?? 'Operator Pasar' }}!
      </h1>
      <p class="text-white/95 text-xs sm:text-sm mt-1.5 font-medium leading-relaxed" data-i18n="hero_subtitle">
        Ekosistem Terpadu Rantai Pasok Gudang Pusat, Penjualan Ritel Toko, dan Kemitraan Grosir B2B
      </p>

      <!-- 3 Pillar Quick Links -->
      <div class="mt-4 flex flex-wrap items-center gap-2">
        <a href="{{ route('warehouse.index') }}" class="bg-white/20 hover:bg-white/30 transition px-3 py-1.5 rounded-xl text-xs font-semibold inline-flex items-center gap-1.5">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
          </svg>
          <span>Gudang: PO & Inbound</span>
        </a>
        <a href="{{ route('pos.index') }}" class="bg-white/20 hover:bg-white/30 transition px-3 py-1.5 rounded-xl text-xs font-semibold inline-flex items-center gap-1.5">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
          </svg>
          <span>Toko: Kasir POS & Counter</span>
        </a>
        <a href="{{ route('b2b.index') }}" class="bg-white/20 hover:bg-white/30 transition px-3 py-1.5 rounded-xl text-xs font-semibold inline-flex items-center gap-1.5">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
          </svg>
          <span>B2B: Kemitraan Grosir</span>
        </a>
      </div>
    </div>

    <!-- Quick Master Product & Suplayer Button -->
    <div class="relative z-10 flex flex-col gap-2 w-full sm:w-auto">
      <a href="{{ route('products.index') }}" class="px-5 py-3 rounded-2xl bg-sidebar hover:bg-sidebarDark text-white text-xs font-bold transition flex items-center justify-center gap-2 shadow-sm text-center">
        <svg class="w-4 h-4 text-brandOrange" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
        </svg>
        <span>Buka Master Produk & UOM</span>
      </a>
      <a href="{{ route('suppliers.index') }}" class="px-5 py-2.5 rounded-2xl bg-white/20 hover:bg-white/30 text-white text-xs font-bold transition flex items-center justify-center gap-2 text-center">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
        </svg>
        <span>Kelola Master Suplayer</span>
      </a>
    </div>
  </div>

  <!-- 2. EXECUTIVE FINANCIAL CARDS (Fase 1 Foundation + RBAC Masking) -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Card 1: Omset Penjualan Hari Ini -->
    <div class="p-5 rounded-[22px] bg-white border border-[#ECEBF4] shadow-sm flex flex-col justify-between">
      <div class="flex items-center justify-between">
        <span class="text-xs font-bold text-textMuted uppercase tracking-wider">Omset Hari Ini</span>
        <span class="p-2 rounded-xl bg-purple-50 text-purple-700">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </span>
      </div>
      <div class="mt-3">
        <p class="text-xl sm:text-2xl font-extrabold text-textMain">Rp 48.920.000</p>
        <div class="flex items-center gap-1.5 mt-1 text-[11px] font-semibold text-emerald-600">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
          <span>+14.2% vs kemarin</span>
        </div>
      </div>
    </div>

    <!-- Card 2: Laba Kotor Berjalan (HPP Protected) -->
    <div class="p-5 rounded-[22px] bg-white border border-[#ECEBF4] shadow-sm flex flex-col justify-between">
      <div class="flex items-center justify-between">
        <span class="text-xs font-bold text-textMuted uppercase tracking-wider">Estimasi Laba Kotor</span>
        <span class="p-2 rounded-xl bg-emerald-50 text-emerald-700">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </span>
      </div>
      <div class="mt-3">
        @canViewProfit
          <p class="text-xl sm:text-2xl font-extrabold text-emerald-600">Rp 8.420.000</p>
          <span class="text-[11px] font-semibold text-textMuted">Margin rata-rata 17.2%</span>
        @else
          <p class="text-xl sm:text-2xl font-extrabold text-textMuted font-mono">Rp ••••••••</p>
          <span class="text-[11px] font-bold text-rose-600">Dirahasiakan (Akses Terbatas)</span>
        @endcanViewProfit
      </div>
    </div>

    <!-- Card 3: Total Piutang Tempo B2B -->
    <div class="p-5 rounded-[22px] bg-white border border-[#ECEBF4] shadow-sm flex flex-col justify-between">
      <div class="flex items-center justify-between">
        <span class="text-xs font-bold text-textMuted uppercase tracking-wider">Piutang Tempo B2B</span>
        <span class="p-2 rounded-xl bg-amber-50 text-amber-700">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </span>
      </div>
      <div class="mt-3">
        <p class="text-xl sm:text-2xl font-extrabold text-amber-600">Rp 128.500.000</p>
        <span class="text-[11px] font-semibold text-textMuted">2 Faktur mendekati jatuh tempo</span>
      </div>
    </div>

    <!-- Card 4: Peringatan Stok Kritis Pasar -->
    <div class="p-5 rounded-[22px] bg-white border border-[#ECEBF4] shadow-sm flex flex-col justify-between">
      <div class="flex items-center justify-between">
        <span class="text-xs font-bold text-textMuted uppercase tracking-wider">Peringatan Stok Kritis</span>
        <span class="p-2 rounded-xl bg-rose-50 text-rose-700">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </span>
      </div>
      <div class="mt-3">
        <p class="text-xl sm:text-2xl font-extrabold text-rose-600">3 Komoditas</p>
        <span class="text-[11px] font-semibold text-textMuted">Segera reorder dari Suplayer</span>
      </div>
    </div>
  </div>

  <!-- 3. INDIKATOR PERGERAKAN STANDAR 5-WARNA SISTEM (PRD Bagian 1.2) -->
  <div class="bg-white rounded-[26px] p-6 border border-[#ECEBF4] shadow-sm space-y-4">
    <div class="flex items-center justify-between">
      <div>
        <h3 class="text-sm font-bold text-textMain">Standar Visual 5 Indikator Pergerakan Sistem</h3>
        <p class="text-xs text-textMuted mt-0.5">Kode warna mutlak pergerakan barang dan audit rantai pasok pasar</p>
      </div>
      <a href="{{ route('audit.index') }}" class="text-xs font-bold text-sidebar hover:underline">Lihat Log Lengkap →</a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 text-xs">
      <!-- Hijau: Barang Masuk -->
      <div class="p-3.5 rounded-2xl bg-[#ECFDF5] border border-[#10B981]/20 flex items-center gap-3">
        <span class="w-3 h-3 rounded-full bg-[#10B981] shrink-0"></span>
        <div>
          <p class="font-bold text-[#065F46] leading-tight">Barang Masuk</p>
          <span class="text-[10px] text-[#047857]">PO & Inbound Gudang</span>
        </div>
      </div>

      <!-- Biru: Transfer -->
      <div class="p-3.5 rounded-2xl bg-[#EFF6FF] border border-[#3B82F6]/20 flex items-center gap-3">
        <span class="w-3 h-3 rounded-full bg-[#3B82F6] shrink-0"></span>
        <div>
          <p class="font-bold text-[#1E40AF] leading-tight">Transfer Internal</p>
          <span class="text-[10px] text-[#2563EB]">Gudang → Toko</span>
        </div>
      </div>

      <!-- Ungu: Penjualan -->
      <div class="p-3.5 rounded-2xl bg-[#F5F3FF] border border-[#8B5CF6]/20 flex items-center gap-3">
        <span class="w-3 h-3 rounded-full bg-[#8B5CF6] shrink-0"></span>
        <div>
          <p class="font-bold text-[#5B21B6] leading-tight">Penjualan Selesai</p>
          <span class="text-[10px] text-[#7C3AED]">Kasir Ritel & B2B</span>
        </div>
      </div>

      <!-- Oranye: Retur -->
      <div class="p-3.5 rounded-2xl bg-[#FFFBEB] border border-[#F59E0B]/20 flex items-center gap-3">
        <span class="w-3 h-3 rounded-full bg-[#F59E0B] shrink-0"></span>
        <div>
          <p class="font-bold text-[#92400E] leading-tight">Retur Barang</p>
          <span class="text-[10px] text-[#D97706]">Ke Suplayer / Konsumen</span>
        </div>
      </div>

      <!-- Merah: Penyesuaian -->
      <div class="p-3.5 rounded-2xl bg-[#FEF2F2] border border-[#EF4444]/20 flex items-center gap-3">
        <span class="w-3 h-3 rounded-full bg-[#EF4444] shrink-0"></span>
        <div>
          <p class="font-bold text-[#991B1B] leading-tight">Penyesuaian Stok</p>
          <span class="text-[10px] text-[#DC2626]">Susut & Stock Opname</span>
        </div>
      </div>
    </div>
  </div>

  <!-- 4. RECENT AUDIT TIMELINE TABLE (Real-Time Transparency) -->
  <div class="bg-white rounded-[26px] border border-[#ECEBF4] overflow-hidden shadow-sm">
    <div class="p-5 border-b border-[#F0EFF6] flex items-center justify-between">
      <div>
        <h3 class="text-sm font-bold text-textMain">10 Mutasi & Transaksi Terakhir</h3>
        <p class="text-xs text-textMuted mt-0.5">Tercatat permanen di Audit Logger dengan data snapshot</p>
      </div>
      <a href="{{ route('audit.index') }}" class="px-3.5 py-1.5 rounded-xl bg-panelBg hover:bg-[#EAE8F2] text-sidebar text-xs font-bold border border-[#E6E4F0] transition">
        Buka Audit Trail Penuh
      </a>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse text-xs">
        <thead>
          <tr class="bg-panelBg text-[11px] font-bold text-textMuted uppercase tracking-wider border-b border-[#ECEBF4]">
            <th class="py-3 px-5">Waktu</th>
            <th class="py-3 px-4">Pengguna</th>
            <th class="py-3 px-4">Role</th>
            <th class="py-3 px-4">Aksi</th>
            <th class="py-3 px-4">Deskripsi Aktivitas</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-[#F0EFF6]">
          @forelse($recentAuditLogs as $log)
            <tr class="hover:bg-panelBg/40 transition">
              <td class="py-3 px-5 text-textMuted font-mono whitespace-nowrap text-[11px]">
                {{ $log->created_at->format('H:i:s') }}
              </td>
              <td class="py-3 px-4 font-bold text-textMain">
                {{ $log->username ?? $log->user?->name ?? 'System' }}
              </td>
              <td class="py-3 px-4">
                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-extrabold uppercase {{ $log->user?->getRoleBadgeClass() ?? 'bg-gray-100 text-gray-700' }}">
                  {{ $log->role }}
                </span>
              </td>
              <td class="py-3 px-4">
                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold font-mono {{ $log->getActionBadgeClass() }}">
                  {{ $log->action }}
                </span>
              </td>
              <td class="py-3 px-4 text-textMain max-w-md truncate">
                {{ $log->description }}
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="py-6 text-center text-textMuted">
                Belum ada aktivitas mutasi tercatat.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</main>
@endsection
