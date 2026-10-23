@extends('layouts.app')

@section('title', 'Audit Trail & Rekam Jejak — PasarHub')
@section('hide_right_panel', '1')

@section('content')
<div class="flex-1 w-full space-y-6">

  <!-- Header Banner -->
  <div class="bg-white rounded-[26px] p-6 border border-[#ECEBF4] flex flex-col md:flex-row items-start md:items-center justify-between gap-4 shadow-sm">
    <div>
      <div class="inline-flex items-center gap-2 bg-sidebar/10 px-3 py-1 rounded-full text-xs font-bold text-sidebar mb-2">
        <span class="w-2 h-2 rounded-full bg-sidebar"></span>
        <span>Fase 2 • Tata Kelola & Akuntabilitas Mutlak</span>
      </div>
      <h1 class="font-display text-2xl font-bold text-textMain">
        Audit Trail & Rekam Jejak Mutasi
      </h1>
      <p class="text-xs text-textMuted mt-0.5 leading-relaxed">
        Pencatatan real-time seluruh mutasi data, login, perubahan harga, dan operasional tanpa approval berjenjang.
      </p>
    </div>

    <div class="flex items-center gap-2 text-xs font-bold text-textMuted bg-panelBg px-4 py-2.5 rounded-xl border border-[#ECEBF4]">
      <span>Total Tercatat: <strong class="text-sidebar">{{ $logs->total() }} Aktivitas</strong></span>
    </div>
  </div>

  <!-- Filter & Search Bar -->
  <div class="bg-white rounded-[22px] p-4 border border-[#ECEBF4] flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 shadow-sm">
    <form method="GET" action="{{ route('audit.index') }}" class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
      <span class="text-xs font-bold text-textMain">Filter Aksi:</span>
      <select name="action" onchange="this.form.submit()" class="px-3 py-1.5 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-semibold text-textMain outline-none focus:border-sidebar">
        <option value="">Semua Aksi</option>
        @foreach($distinctActions as $act)
          <option value="{{ $act }}" {{ request('action') === $act ? 'selected' : '' }}>{{ $act }}</option>
        @endforeach
      </select>

      <span class="text-xs font-bold text-textMain ml-2">Role:</span>
      <select name="role" onchange="this.form.submit()" class="px-3 py-1.5 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-semibold text-textMain outline-none focus:border-sidebar">
        <option value="">Semua Role</option>
        @foreach(\App\Models\User::ALL_ROLES as $rKey => $rLabel)
          <option value="{{ $rKey }}" {{ request('role') === $rKey ? 'selected' : '' }}>{{ $rLabel }}</option>
        @endforeach
      </select>

      @if(request('search'))
        <input type="hidden" name="search" value="{{ request('search') }}">
      @endif

      @if(request('action') || request('role') || request('search'))
        <a href="{{ route('audit.index') }}" class="text-[11px] font-bold text-rose-500 hover:underline ml-2">Reset Filter</a>
      @endif
    </form>

    <form method="GET" action="{{ route('audit.index') }}" class="relative w-full sm:w-72">
      @if(request('action'))
        <input type="hidden" name="action" value="{{ request('action') }}">
      @endif
      @if(request('role'))
        <input type="hidden" name="role" value="{{ request('role') }}">
      @endif
      <input 
        type="text" 
        name="search"
        value="{{ request('search') }}"
        placeholder="Cari user, deskripsi, atau IP..." 
        class="w-full px-4 py-2 rounded-xl bg-panelBg border border-[#E6E4F0] text-xs font-medium text-textMain placeholder-textMuted outline-none focus:border-sidebar pr-9"
      />
      <button type="submit" class="absolute right-3 top-2.5 text-textMuted hover:text-sidebar">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
      </button>
    </form>
  </div>

  <!-- Audit Table -->
  <div class="bg-white rounded-[26px] border border-[#ECEBF4] overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-panelBg text-[11px] font-bold text-textMuted uppercase tracking-wider border-b border-[#ECEBF4]">
            <th class="py-3.5 px-5">Waktu</th>
            <th class="py-3.5 px-4">Pengguna / Akun</th>
            <th class="py-3.5 px-4">Role</th>
            <th class="py-3.5 px-4">Tindakan (Action)</th>
            <th class="py-3.5 px-4">Rincian Deskripsi</th>
            <th class="py-3.5 px-4">Snapshot Data</th>
            <th class="py-3.5 px-5 text-right">IP Address</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-[#F0EFF6] text-xs">
          @forelse($logs as $log)
            <tr class="hover:bg-panelBg/40 transition">
              <td class="py-3.5 px-5 whitespace-nowrap text-textMuted font-mono text-[11px]">
                {{ $log->created_at->format('d M Y H:i:s') }}
              </td>
              <td class="py-3.5 px-4 font-bold text-textMain">
                {{ $log->username ?? $log->user?->name ?? 'System' }}
              </td>
              <td class="py-3.5 px-4">
                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-extrabold uppercase {{ $log->user?->getRoleBadgeClass() ?? 'bg-gray-100 text-gray-700' }}">
                  {{ $log->role }}
                </span>
              </td>
              <td class="py-3.5 px-4">
                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold font-mono {{ $log->getActionBadgeClass() }}">
                  {{ $log->action }}
                </span>
              </td>
              <td class="py-3.5 px-4 text-textMain max-w-sm">
                {{ $log->description }}
              </td>
              <td class="py-3.5 px-4">
                @if(!empty($log->data_snapshot) || !empty($log->new_values))
                  <button 
                    onclick="viewSnapshotModal({{ json_encode($log->data_snapshot ?: $log->new_values) }})"
                    class="px-2 py-1 rounded-md bg-panelBg hover:bg-[#EAE8F2] text-sidebar text-[11px] font-bold border border-[#E6E4F0] transition"
                  >
                    Lihat Snapshot
                  </button>
                @else
                  <span class="text-textMuted">-</span>
                @endif
              </td>
              <td class="py-3.5 px-5 text-right font-mono text-textMuted text-[11px]">
                {{ $log->ip_address ?? '127.0.0.1' }}
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="py-12 text-center text-textMuted">
                Belum ada rekaman audit trail yang sesuai filter.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($logs->hasPages())
      <div class="p-4 border-t border-[#F0EFF6]">
        {{ $logs->links() }}
      </div>
    @endif
  </div>

</div>

<!-- Snapshot Modal -->
<div id="snapshotModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
  <div class="bg-white rounded-[26px] max-w-lg w-full p-6 border border-[#ECEBF4] shadow-2xl space-y-4">
    <div class="flex items-center justify-between border-b border-[#F0EFF6] pb-3">
      <h3 class="text-sm font-bold text-textMain">Data Snapshot Audit</h3>
      <button onclick="document.getElementById('snapshotModal').classList.add('hidden')" class="w-7 h-7 rounded-lg bg-panelBg flex items-center justify-center text-textMuted">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>
    <pre id="snapshotContent" class="p-3 rounded-xl bg-panelBg border border-[#E6E4F0] text-[11px] font-mono text-textMain overflow-x-auto max-h-72"></pre>
  </div>
</div>
@endsection

@push('scripts')
<script>
  function viewSnapshotModal(data) {
    document.getElementById('snapshotContent').innerText = JSON.stringify(data, null, 2);
    document.getElementById('snapshotModal')?.classList.remove('hidden');
  }
</script>
@endpush
