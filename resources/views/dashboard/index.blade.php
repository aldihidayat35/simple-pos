@extends('layouts.app')

@section('title', 'PasarHub — Sistem Manajemen Operasional Pasar Terpadu (Gudang, Toko, & B2B)')

@section('content')
<!-- LEFT / CENTER DYNAMIC CONTENT AREA -->
<main class="flex-1 w-full space-y-6">

  <!-- Dynamic Sub-Menu Active Filter Banner (Shows when user switches sub-menus) -->
  <div id="subMenuContextBox" class="hidden bg-panelBg border border-[#E8E6F2] rounded-[18px] px-4 py-3 items-center justify-between">
    <div class="flex items-center gap-2.5">
      <span class="w-2 h-2 rounded-full bg-sidebar"></span>
      <p id="subMenuContextText" class="text-xs font-semibold text-textMain"></p>
    </div>
    <button onclick="selectSubMenu(0)" class="text-[11px] font-bold text-brandCoral hover:underline" data-i18n="btn_reset_view">Reset Tampilan</button>
  </div>

  <!-- PAGE 0 (INDEX 0): DASBOR UTAMA & KESEHATAN FINANSIAL (DEFAULT FASE 1) -->
  @include('dashboard.modules.summary')

  <!-- PAGE 1 (INDEX 1): OPERASIONAL GUDANG PUSAT -->
  @include('warehouse.module')

  <!-- PAGE 2 (INDEX 2): OPERASIONAL TOKO & KASIR POS -->
  @include('pos.module')

  <!-- PAGE 3 (INDEX 3): KEMITRAAN B2B & SALES -->
  @include('b2b.module')

  <!-- PAGE 4 (INDEX 4): FEED PERGERAKAN 5-WARNA & ANOMALI -->
  @include('audit.module')

  <!-- PAGE 5 (INDEX 5): MASTER PRODUK, UOM, & MEMBER QR -->
  @include('products.module')

</main>
@endsection
