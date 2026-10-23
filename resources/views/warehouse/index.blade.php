@extends('layouts.app')

@section('title', 'Operasional Gudang Pusat — PasarHub')
@section('hide_right_panel', '1')

@section('content')
<div class="flex-1 w-full space-y-6">

  <!-- Header Banner -->
  <div class="bg-white rounded-[26px] p-6 border border-[#ECEBF4] flex flex-col md:flex-row items-start md:items-center justify-between gap-4 shadow-sm">
    <div>
      <div class="inline-flex items-center gap-2 bg-sidebar/10 px-3 py-1 rounded-full text-xs font-bold text-sidebar mb-2">
        <span class="w-2 h-2 rounded-full bg-sidebar"></span>
        <span>Fase 4 • Operasional Rantai Pasok Gudang</span>
      </div>
      <h1 class="font-display text-2xl font-bold text-textMain">
        Operasional Gudang Pusat & Inbound PO
      </h1>
      <p class="text-xs text-textMuted mt-0.5 leading-relaxed">
        Penerimaan barang dari suplayer via Purchase Order (PO), verifikasi timbangan/RFID dock, dan transfer stok ke toko ritel.
      </p>
    </div>

    <div class="flex items-center gap-2">
      <span class="px-3.5 py-1.5 rounded-xl bg-amber-100 text-amber-900 border border-amber-200 text-xs font-extrabold uppercase tracking-wide">
        Siap Dibangun di Fase 4
      </span>
    </div>
  </div>

  <!-- Key Metrics Preview -->
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="p-5 rounded-2xl bg-white border border-[#ECEBF4] shadow-sm">
      <span class="text-xs font-bold text-textMuted">Total SKU Tersedia di Gudang</span>
      <p class="text-2xl font-extrabold text-sidebar mt-1">{{ $totalSkuGudang }} SKU</p>
      <span class="text-[10px] text-textMuted">Siap didistribusikan ke counter toko</span>
    </div>

    <div class="p-5 rounded-2xl bg-white border border-[#ECEBF4] shadow-sm">
      <span class="text-xs font-bold text-textMuted">Mitra Suplayer Terdaftar</span>
      <p class="text-2xl font-extrabold text-emerald-600 mt-1">{{ $suppliersCount }} Suplayer</p>
      <span class="text-[10px] text-textMuted">Terhubung untuk alur PO resmi</span>
    </div>

    <div class="p-5 rounded-2xl bg-white border border-[#ECEBF4] shadow-sm">
      <span class="text-xs font-bold text-textMuted">Standar Penerimaan Dock</span>
      <p class="text-2xl font-extrabold text-brandOrange mt-1">RFID & Timbangan</p>
      <span class="text-[10px] text-textMuted">Verifikasi berat bruto vs toleransi susut</span>
    </div>
  </div>

  <!-- Roadmap Blueprint Section -->
  <div class="p-6 rounded-[26px] bg-panelBg border border-[#E6E4F0] space-y-4">
    <div class="flex items-center gap-2 text-sidebar font-bold text-sm">
      <svg class="w-5 h-5 text-sidebar" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
      </svg>
      <h3>Rencana Fitur Fase 4 (Alur Pembelian & Penerimaan Barang PO Gudang)</h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
      <div class="p-4 rounded-xl bg-white border border-[#E8E6F2] space-y-2">
        <div class="flex items-center gap-2 font-bold text-textMain">
          <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center text-[10px]">1</span>
          <span>Penerbitan PO Suplayer</span>
        </div>
        <p class="text-textMuted leading-relaxed">
          Staf gudang membuat PO resmi dengan referensi satuan kemasan besar (Karung/Dus) dan harga beli kesepakatan.
        </p>
      </div>

      <div class="p-4 rounded-xl bg-white border border-[#E8E6F2] space-y-2">
        <div class="flex items-center gap-2 font-bold text-textMain">
          <span class="w-5 h-5 rounded-full bg-blue-100 text-blue-800 flex items-center justify-center text-[10px]">2</span>
          <span>Verifikasi Timbangan & Susut</span>
        </div>
        <p class="text-textMuted leading-relaxed">
          Input berat timbangan fisik saat truk tiba. Sistem otomatis memvalidasi toleransi selisih susut pasar.
        </p>
      </div>

      <div class="p-4 rounded-xl bg-white border border-[#E8E6F2] space-y-2">
        <div class="flex items-center gap-2 font-bold text-textMain">
          <span class="w-5 h-5 rounded-full bg-purple-100 text-purple-800 flex items-center justify-center text-[10px]">3</span>
          <span>Transfer Stok Otomatis ke Toko</span>
        </div>
        <p class="text-textMuted leading-relaxed">
          Konversi satuan otomatis (misal 1 Karung 50Kg dipecah jadi 50 Kg saat dialokasikan ke display kasir toko).
        </p>
      </div>
    </div>
  </div>

</div>
@endsection
