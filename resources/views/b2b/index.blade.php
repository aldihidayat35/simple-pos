@extends('layouts.app')

@section('title', 'Kemitraan B2B & Piutang Tempo — PasarHub')
@section('hide_right_panel', '1')

@section('content')
<div class="flex-1 w-full space-y-6">

  <!-- Header Banner -->
  <div class="bg-white rounded-[26px] p-6 border border-[#ECEBF4] flex flex-col md:flex-row items-start md:items-center justify-between gap-4 shadow-sm">
    <div>
      <div class="inline-flex items-center gap-2 bg-sidebar/10 px-3 py-1 rounded-full text-xs font-bold text-sidebar mb-2">
        <span class="w-2 h-2 rounded-full bg-sidebar"></span>
        <span>Fase 6 • Grosir B2B & Plafon Piutang</span>
      </div>
      <h1 class="font-display text-2xl font-bold text-textMain">
        Kemitraan Grosir B2B & Batas Plafon Piutang
      </h1>
      <p class="text-xs text-textMuted mt-0.5 leading-relaxed">
        Pemesanan grosir kemitraan, plafon kredit limit per mitra, dan proteksi auto-block saat melewati jatuh tempo (TOP 30 hari).
      </p>
    </div>

    <div class="flex items-center gap-2">
      <span class="px-3.5 py-1.5 rounded-xl bg-amber-100 text-amber-900 border border-amber-200 text-xs font-extrabold uppercase tracking-wide">
        Siap Dibangun di Fase 6
      </span>
    </div>
  </div>

  <!-- Key Metrics Preview -->
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="p-5 rounded-2xl bg-white border border-[#ECEBF4] shadow-sm">
      <span class="text-xs font-bold text-textMuted">Mitra Grosir B2B Terdaftar</span>
      <p class="text-2xl font-extrabold text-sidebar mt-1">{{ $b2bPartners->count() }} Mitra Aktif</p>
      <span class="text-[10px] text-textMuted">Akun dengan akses order B2B</span>
    </div>

    <div class="p-5 rounded-2xl bg-white border border-[#ECEBF4] shadow-sm">
      <span class="text-xs font-bold text-textMuted">Plafon Kredit Default</span>
      <p class="text-2xl font-extrabold text-emerald-600 mt-1">Rp {{ number_format($defaultCreditLimit, 0, ',', '.') }}</p>
      <span class="text-[10px] text-textMuted">Batas saldo piutang tempo standar</span>
    </div>

    <div class="p-5 rounded-2xl bg-white border border-[#ECEBF4] shadow-sm">
      <span class="text-xs font-bold text-textMuted">Auto-Lock Overdue</span>
      <p class="text-2xl font-extrabold text-rose-600 mt-1">{{ $autoBlockDays }} Hari Jatuh Tempo</p>
      <span class="text-[10px] text-textMuted">Terkunci otomatis jika ada faktur macet</span>
    </div>
  </div>

  <!-- Roadmap Blueprint Section -->
  <div class="p-6 rounded-[26px] bg-panelBg border border-[#E6E4F0] space-y-4">
    <div class="flex items-center gap-2 text-sidebar font-bold text-sm">
      <svg class="w-5 h-5 text-sidebar" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
      </svg>
      <h3>Rencana Fitur Fase 6 (Kemitraan B2B & Manajemen Plafon Piutang)</h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
      <div class="p-4 rounded-xl bg-white border border-[#E8E6F2] space-y-2">
        <div class="flex items-center gap-2 font-bold text-textMain">
          <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center text-[10px]">1</span>
          <span>Katalog Grosir Mitra B2B</span>
        </div>
        <p class="text-textMuted leading-relaxed">
          Mitra login dengan portal mandiri untuk memesan komoditas satuan besar dengan harga tier volume khusus.
        </p>
      </div>

      <div class="p-4 rounded-xl bg-white border border-[#E8E6F2] space-y-2">
        <div class="flex items-center gap-2 font-bold text-textMain">
          <span class="w-5 h-5 rounded-full bg-amber-100 text-amber-800 flex items-center justify-center text-[10px]">2</span>
          <span>Batas Plafon Kredit Real-Time</span>
        </div>
        <p class="text-textMuted leading-relaxed">
          Setiap pesanan tempo otomatis mengurangi sisa plafon piutang. Order tertolak jika melebihi limit plafon.
        </p>
      </div>

      <div class="p-4 rounded-xl bg-white border border-[#E8E6F2] space-y-2">
        <div class="flex items-center gap-2 font-bold text-textMain">
          <span class="w-5 h-5 rounded-full bg-rose-100 text-rose-800 flex items-center justify-center text-[10px]">3</span>
          <span>Auto-Block Macet 30 Hari</span>
        </div>
        <p class="text-textMuted leading-relaxed">
          Kunci sistem otomatis menghentikan pesanan baru jika ada faktur tempo yang belum lunas melewati batas hari.
        </p>
      </div>
    </div>
  </div>

</div>
@endsection
