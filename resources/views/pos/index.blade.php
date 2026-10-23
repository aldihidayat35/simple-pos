@extends('layouts.app')

@section('title', 'Operasional Toko & Kasir POS — PasarHub')
@section('hide_right_panel', '1')

@section('content')
<div class="flex-1 w-full space-y-6">

  <!-- Header Banner -->
  <div class="bg-white rounded-[26px] p-6 border border-[#ECEBF4] flex flex-col md:flex-row items-start md:items-center justify-between gap-4 shadow-sm">
    <div>
      <div class="inline-flex items-center gap-2 bg-sidebar/10 px-3 py-1 rounded-full text-xs font-bold text-sidebar mb-2">
        <span class="w-2 h-2 rounded-full bg-sidebar"></span>
        <span>Fase 5 • Operasional Kasir & Toko Ritel</span>
      </div>
      <h1 class="font-display text-2xl font-bold text-textMain">
        Operasional Toko & Kasir Cepat POS
      </h1>
      <p class="text-xs text-textMuted mt-0.5 leading-relaxed">
        Terminal transaksi kilat kasir dengan proteksi Floor Price terkunci otomatis, multi-payment (Tunai, QRIS, Transfer), dan kas kecil toko.
      </p>
    </div>

    <div class="flex items-center gap-2">
      <span class="px-3.5 py-1.5 rounded-xl bg-amber-100 text-amber-900 border border-amber-200 text-xs font-extrabold uppercase tracking-wide">
        Siap Dibangun di Fase 5
      </span>
    </div>
  </div>

  <!-- Key Metrics Preview -->
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="p-5 rounded-2xl bg-white border border-[#ECEBF4] shadow-sm">
      <span class="text-xs font-bold text-textMuted">Komoditas Siap Jual di Toko</span>
      <p class="text-2xl font-extrabold text-sidebar mt-1">{{ $productsInStore->count() }} SKU</p>
      <span class="text-[10px] text-textMuted">Tersedia untuk transaksi ritel</span>
    </div>

    <div class="p-5 rounded-2xl bg-white border border-[#ECEBF4] shadow-sm">
      <span class="text-xs font-bold text-textMuted">Kunci Mutlak Margin POS</span>
      <p class="text-2xl font-extrabold text-emerald-600 mt-1">Floor Price Locked</p>
      <span class="text-[10px] text-textMuted">Kasir tidak dapat input harga di bawah HPP</span>
    </div>

    <div class="p-5 rounded-2xl bg-white border border-[#ECEBF4] shadow-sm">
      <span class="text-xs font-bold text-textMuted">Tata Kelola Kas Toko</span>
      <p class="text-2xl font-extrabold text-brandOrange mt-1">Petty Cash Tracking</p>
      <span class="text-[10px] text-textMuted">Modal awal kasir, kas operasional, & setoran harian</span>
    </div>
  </div>

  <!-- Roadmap Blueprint Section -->
  <div class="p-6 rounded-[26px] bg-panelBg border border-[#E6E4F0] space-y-4">
    <div class="flex items-center gap-2 text-sidebar font-bold text-sm">
      <svg class="w-5 h-5 text-sidebar" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
      </svg>
      <h3>Rencana Fitur Fase 5 (Kasir POS, Kunci Floor Price, & Kas Kecil Toko)</h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
      <div class="p-4 rounded-xl bg-white border border-[#E8E6F2] space-y-2">
        <div class="flex items-center gap-2 font-bold text-textMain">
          <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center text-[10px]">1</span>
          <span>Fast-Checkout POS Scanner</span>
        </div>
        <p class="text-textMuted leading-relaxed">
          Pencarian kilat via barcode 1D atau nama, pemilihan satuan eceran vs grosir otomatis, dan multi-payment.
        </p>
      </div>

      <div class="p-4 rounded-xl bg-white border border-[#E8E6F2] space-y-2">
        <div class="flex items-center gap-2 font-bold text-textMain">
          <span class="w-5 h-5 rounded-full bg-rose-100 text-rose-800 flex items-center justify-center text-[10px]">2</span>
          <span>System Lock Floor Price</span>
        </div>
        <p class="text-textMuted leading-relaxed">
          Sistem otomatis menolak transaksi jika ada harga manual di bawah batas floor price (HPP + margin minimum).
        </p>
      </div>

      <div class="p-4 rounded-xl bg-white border border-[#E8E6F2] space-y-2">
        <div class="flex items-center gap-2 font-bold text-textMain">
          <span class="w-5 h-5 rounded-full bg-purple-100 text-purple-800 flex items-center justify-center text-[10px]">3</span>
          <span>Buku Kas Kecil Toko</span>
        </div>
        <p class="text-textMuted leading-relaxed">
          Pencatatan kas operasional toko (uang kembalian kasir, biaya kebersihan, es batu/packing) dengan audit log.
        </p>
      </div>
    </div>
  </div>

</div>
@endsection
