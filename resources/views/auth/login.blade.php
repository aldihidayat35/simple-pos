<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Masuk Sistem — Sistem Operasional Pasar Terpadu</title>

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Google Fonts: Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&display=swap" rel="stylesheet">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['"Poppins"', 'sans-serif'],
            display: ['"Poppins"', 'sans-serif'],
            poppins: ['"Poppins"', 'sans-serif'],
          },
          colors: {
            cream: '#FAD9B8',
            sidebar: '#342A6E',
            sidebarDark: '#292059',
            brandOrange: '#F29F3D',
            brandCoral: '#E86B74',
            brandCyan: '#7AC7D9',
            brandLavender: '#E9E8F5',
            panelBg: '#F6F6FA',
            textMain: '#382E6B',
            textMuted: '#9490AD',
            moveGreen: '#10B981',
            moveBlue: '#3B82F6',
            movePurple: '#8B5CF6',
            moveOrange: '#F59E0B',
            moveRed: '#EF4444'
          }
        }
      }
    }
  </script>

  <style>
    * {
      font-family: 'Poppins', sans-serif;
    }
    body {
      background-color: #F6F6FA;
      color: #382E6B;
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="min-h-screen flex flex-col justify-between py-6 px-4 sm:px-6 lg:px-8">

  <!-- Header Branding -->
  <div class="max-w-7xl mx-auto w-full flex items-center justify-between py-2">
    <div class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-2xl bg-sidebar flex items-center justify-center shadow-sm">
        <svg class="w-5 h-5 text-brandOrange" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg>
      </div>
      <div>
        <h1 class="text-lg font-bold text-sidebar leading-tight">Pasar<span class="text-brandOrange font-extrabold">Hub</span></h1>
        <p class="text-[11px] font-medium text-textMuted">Sistem Operasional Pasar Terpadu (Gudang, Toko, & B2B)</p>
      </div>
    </div>

    <!-- Security Badge -->
    <div class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-white border border-[#E6E4F0] text-xs font-semibold text-sidebar">
      <svg class="w-4 h-4 text-moveGreen" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
      </svg>
      <span>Zero-Approval RBAC & Audit Trail Aktif</span>
    </div>
  </div>

  <!-- Main Login & Role Demo Container -->
  <div class="max-w-7xl mx-auto w-full my-6 grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    
    <!-- Left Column: Standard Login Form -->
    <div class="lg:col-span-5 bg-white rounded-[26px] p-6 sm:p-8 border border-[#ECEBF4] shadow-sm">
      <div class="mb-6">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brandOrange/10 text-brandOrange text-xs font-bold mb-3">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
          </svg>
          Autentikasi Terenkripsi
        </span>
        <h2 class="text-2xl font-bold text-textMain">Masuk Terminal</h2>
        <p class="text-xs text-textMuted mt-1">Masukkan username akun atau pilih peran cepat di panel demo sebelah kanan.</p>
      </div>

      <!-- Flash Alerts -->
      @if (session('success'))
        <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center gap-2">
          <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
          </svg>
          <span>{{ session('success') }}</span>
        </div>
      @endif

      @if ($errors->any())
        <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium space-y-1">
          @foreach ($errors->all() as $error)
            <div class="flex items-center gap-2">
              <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span>{{ $error }}</span>
            </div>
          @endforeach
        </div>
      @endif

      <!-- Standard Form -->
      <form id="loginForm" method="POST" action="{{ route('login.submit') }}" class="space-y-4">
        @csrf

        <!-- Username / Email -->
        <div>
          <label for="usernameInput" class="block text-xs font-bold text-textMain mb-1.5">Username atau Email</label>
          <div class="relative">
            <input 
              type="text" 
              name="username" 
              id="usernameInput" 
              value="{{ old('username', 'admin') }}" 
              required 
              placeholder="Contoh: admin, owner, staftoko"
              class="w-full px-4 py-3 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar focus:bg-white text-xs font-semibold text-textMain placeholder-textMuted outline-none transition"
            />
            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-textMuted">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
            </div>
          </div>
        </div>

        <!-- Password -->
        <div>
          <div class="flex items-center justify-between mb-1.5">
            <label for="passwordInput" class="block text-xs font-bold text-textMain">Kata Sandi</label>
            <span class="text-[10px] font-semibold text-textMuted">Default demo: password123</span>
          </div>
          <div class="relative">
            <input 
              type="password" 
              name="password" 
              id="passwordInput" 
              value="password123" 
              required 
              placeholder="••••••••"
              class="w-full px-4 py-3 rounded-xl bg-panelBg border border-[#E6E4F0] focus:border-sidebar focus:bg-white text-xs font-semibold text-textMain placeholder-textMuted outline-none transition"
            />
            <button 
              type="button" 
              onclick="togglePasswordVisibility()" 
              class="absolute inset-y-0 right-3 flex items-center text-textMuted hover:text-textMain transition"
              aria-label="Tampilkan Kata Sandi"
            >
              <svg id="eyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Remember Me Checkbox -->
        <div class="flex items-center justify-between pt-1">
          <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="remember" class="w-4 h-4 rounded text-sidebar border-[#E6E4F0] focus:ring-sidebar" checked>
            <span class="text-xs text-textMuted font-medium">Ingat Sesi di Perangkat Ini</span>
          </label>
          <span class="text-[11px] font-bold text-sidebar hover:underline cursor-pointer" onclick="fillCredential('admin', 'password123')">
            Reset Demo Form
          </span>
        </div>

        <!-- Submit Button -->
        <button 
          type="submit" 
          class="w-full min-h-[48px] py-3 px-6 rounded-xl bg-sidebar hover:bg-sidebarDark active:scale-98 text-white font-bold text-xs tracking-wide transition flex items-center justify-center gap-2 shadow-sm mt-3"
        >
          <svg class="w-4 h-4 text-brandOrange" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
          </svg>
          <span>Masuk ke Sistem Operasional</span>
        </button>
      </form>

      <!-- Architecture Rule Reminder -->
      <div class="mt-6 pt-5 border-t border-[#F0EFF6] flex items-start gap-2.5 text-textMuted text-[11px] leading-relaxed">
        <svg class="w-4 h-4 text-sidebar shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>
          <strong class="text-textMain font-bold">Aturan Mutlak PRD:</strong> Tanpa antrean approval berjenjang. Setiap operator bertanggung jawab mandiri dengan pelacakan forensik pada tabel <code>audit_logs</code>.
        </span>
      </div>
    </div>

    <!-- Right Column: Quick Demo Role Selector (8 Roles RBAC) -->
    <div class="lg:col-span-7 space-y-4">
      <div class="bg-white rounded-[26px] p-6 sm:p-7 border border-[#ECEBF4] shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-[#F0EFF6] pb-4 mb-4">
          <div>
            <h3 class="text-base font-bold text-textMain flex items-center gap-2">
              <span class="w-2.5 h-2.5 rounded-full bg-brandOrange"></span>
              Pilih Cepat Peran Demo (8 Role RBAC)
            </h3>
            <p class="text-xs text-textMuted mt-0.5">Klik salah satu kartu peran di bawah untuk menguji pembatasan halaman, izin HPP, dan mode Read-Only secara langsung.</p>
          </div>
          <span class="text-[11px] font-bold text-sidebar bg-sidebar/10 px-3 py-1 rounded-full self-start sm:self-auto shrink-0">
            Fase 2 RBAC
          </span>
        </div>

        <!-- 8 Roles Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          
          <!-- Role 1: Super Admin -->
          <div 
            onclick="quickLoginRole('admin', 'password123')"
            class="group p-4 rounded-2xl border border-[#ECEBF4] hover:border-sidebar bg-white hover:bg-panelBg/70 transition cursor-pointer flex flex-col justify-between"
          >
            <div class="flex items-center justify-between">
              <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-wide bg-purple-100 text-purple-700">
                Super Admin
              </span>
              <span class="text-[10px] font-mono text-textMuted group-hover:text-sidebar font-bold">@admin</span>
            </div>
            <div class="mt-2.5">
              <p class="text-xs font-bold text-textMain group-hover:text-sidebar">Super Admin Sistem</p>
              <p class="text-[11px] text-textMuted mt-0.5">Akses penuh, manajemen pengguna, konfigurasi parameter kunci (System Locks).</p>
            </div>
            <div class="mt-3 pt-2.5 border-t border-[#F0EFF6] flex items-center justify-between text-[10px] font-semibold">
              <span class="text-moveGreen">HPP & Laba: Terbuka</span>
              <span class="text-purple-600">Hak: Penuh</span>
            </div>
          </div>

          <!-- Role 2: Owner -->
          <div 
            onclick="quickLoginRole('owner', 'password123')"
            class="group p-4 rounded-2xl border border-[#ECEBF4] hover:border-sidebar bg-white hover:bg-panelBg/70 transition cursor-pointer flex flex-col justify-between"
          >
            <div class="flex items-center justify-between">
              <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-wide bg-amber-100 text-amber-700">
                Owner
              </span>
              <span class="text-[10px] font-mono text-textMuted group-hover:text-sidebar font-bold">@owner</span>
            </div>
            <div class="mt-2.5">
              <p class="text-xs font-bold text-textMain group-hover:text-sidebar">Pemilik Bisnis (Pengawas)</p>
              <p class="text-[11px] text-textMuted mt-0.5">Melihat metrik finansial, audit trail & anomali. Terkunci Read-Only tanpa modifikasi.</p>
            </div>
            <div class="mt-3 pt-2.5 border-t border-[#F0EFF6] flex items-center justify-between text-[10px] font-semibold">
              <span class="text-moveGreen">HPP & Laba: Terbuka</span>
              <span class="text-amber-600">Mode: Read-Only Penuh</span>
            </div>
          </div>

          <!-- Role 3: Kepala Toko -->
          <div 
            onclick="quickLoginRole('kepalatoko', 'password123')"
            class="group p-4 rounded-2xl border border-[#ECEBF4] hover:border-sidebar bg-white hover:bg-panelBg/70 transition cursor-pointer flex flex-col justify-between"
          >
            <div class="flex items-center justify-between">
              <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-wide bg-blue-100 text-blue-700">
                Kep. Toko
              </span>
              <span class="text-[10px] font-mono text-textMuted group-hover:text-sidebar font-bold">@kepalatoko</span>
            </div>
            <div class="mt-2.5">
              <p class="text-xs font-bold text-textMain group-hover:text-sidebar">Kepala Operasional Toko</p>
              <p class="text-[11px] text-textMuted mt-0.5">Penjualan ritel, penyesuaian harga promo, verifikasi shift kasir & pembukuan harian.</p>
            </div>
            <div class="mt-3 pt-2.5 border-t border-[#F0EFF6] flex items-center justify-between text-[10px] font-semibold">
              <span class="text-moveGreen">HPP & Laba: Terbuka</span>
              <span class="text-blue-600">Hak: Operasional Toko</span>
            </div>
          </div>

          <!-- Role 4: Kepala Gudang -->
          <div 
            onclick="quickLoginRole('kepalagudang', 'password123')"
            class="group p-4 rounded-2xl border border-[#ECEBF4] hover:border-sidebar bg-white hover:bg-panelBg/70 transition cursor-pointer flex flex-col justify-between"
          >
            <div class="flex items-center justify-between">
              <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-wide bg-indigo-100 text-indigo-700">
                Kep. Gudang
              </span>
              <span class="text-[10px] font-mono text-textMuted group-hover:text-sidebar font-bold">@kepalagudang</span>
            </div>
            <div class="mt-2.5">
              <p class="text-xs font-bold text-textMain group-hover:text-sidebar">Kepala Logistik & Gudang</p>
              <p class="text-[11px] text-textMuted mt-0.5">Penerimaan PO suplayer, approval opname parsial, input stok emergency mandiri.</p>
            </div>
            <div class="mt-3 pt-2.5 border-t border-[#F0EFF6] flex items-center justify-between text-[10px] font-semibold">
              <span class="text-moveGreen">HPP & Laba: Terbuka</span>
              <span class="text-indigo-600">Hak: Operasional Gudang</span>
            </div>
          </div>

          <!-- Role 5: Staf Gudang -->
          <div 
            onclick="quickLoginRole('stafgudang', 'password123')"
            class="group p-4 rounded-2xl border border-[#ECEBF4] hover:border-sidebar bg-white hover:bg-panelBg/70 transition cursor-pointer flex flex-col justify-between"
          >
            <div class="flex items-center justify-between">
              <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-wide bg-slate-100 text-slate-700">
                Staf Gudang
              </span>
              <span class="text-[10px] font-mono text-textMuted group-hover:text-sidebar font-bold">@stafgudang</span>
            </div>
            <div class="mt-2.5">
              <p class="text-xs font-bold text-textMain group-hover:text-sidebar">Operator Gudang Fisik</p>
              <p class="text-[11px] text-textMuted mt-0.5">Scan barcode penerimaan, sortir rak, picking order, stock opname fisik.</p>
            </div>
            <div class="mt-3 pt-2.5 border-t border-[#F0EFF6] flex items-center justify-between text-[10px] font-semibold">
              <span class="text-brandCoral font-bold">HPP & Laba: DITUTUP</span>
              <span class="text-slate-600">Hak: Fisik & Barcode</span>
            </div>
          </div>

          <!-- Role 6: Staf Toko -->
          <div 
            onclick="quickLoginRole('staftoko', 'password123')"
            class="group p-4 rounded-2xl border border-[#ECEBF4] hover:border-sidebar bg-white hover:bg-panelBg/70 transition cursor-pointer flex flex-col justify-between"
          >
            <div class="flex items-center justify-between">
              <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-wide bg-sky-100 text-sky-700">
                Staf Toko
              </span>
              <span class="text-[10px] font-mono text-textMuted group-hover:text-sidebar font-bold">@staftoko</span>
            </div>
            <div class="mt-2.5">
              <p class="text-xs font-bold text-textMain group-hover:text-sidebar">Kasir & Pramuniaga Ritel</p>
              <p class="text-[11px] text-textMuted mt-0.5">Kasir kilat POS, scan QR member, setor kas buka/tutup laci harian.</p>
            </div>
            <div class="mt-3 pt-2.5 border-t border-[#F0EFF6] flex items-center justify-between text-[10px] font-semibold">
              <span class="text-brandCoral font-bold">HPP & Laba: DITUTUP</span>
              <span class="text-sky-600">Hak: Kasir POS</span>
            </div>
          </div>

          <!-- Role 7: Sales -->
          <div 
            onclick="quickLoginRole('sales', 'password123')"
            class="group p-4 rounded-2xl border border-[#ECEBF4] hover:border-sidebar bg-white hover:bg-panelBg/70 transition cursor-pointer flex flex-col justify-between"
          >
            <div class="flex items-center justify-between">
              <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-wide bg-emerald-100 text-emerald-700">
                Sales
              </span>
              <span class="text-[10px] font-mono text-textMuted group-hover:text-sidebar font-bold">@sales</span>
            </div>
            <div class="mt-2.5">
              <p class="text-xs font-bold text-textMain group-hover:text-sidebar">Sales Eksternal / B2B</p>
              <p class="text-[11px] text-textMuted mt-0.5">Kunjungan toko mitra, input order grosir, cek plafon kredit pelanggan.</p>
            </div>
            <div class="mt-3 pt-2.5 border-t border-[#F0EFF6] flex items-center justify-between text-[10px] font-semibold">
              <span class="text-brandCoral font-bold">HPP & Laba: DITUTUP</span>
              <span class="text-emerald-600">Hak: Pesanan Grosir</span>
            </div>
          </div>

          <!-- Role 8: B2B -->
          <div 
            onclick="quickLoginRole('b2b', 'password123')"
            class="group p-4 rounded-2xl border border-[#ECEBF4] hover:border-sidebar bg-white hover:bg-panelBg/70 transition cursor-pointer flex flex-col justify-between"
          >
            <div class="flex items-center justify-between">
              <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-wide bg-teal-100 text-teal-700">
                Mitra B2B
              </span>
              <span class="text-[10px] font-mono text-textMuted group-hover:text-sidebar font-bold">@b2b</span>
            </div>
            <div class="mt-2.5">
              <p class="text-xs font-bold text-textMain group-hover:text-sidebar">Mitra Grosir Resmi</p>
              <p class="text-[11px] text-textMuted mt-0.5">Portal pesanan mandiri, unduh faktur, pantau jatuh tempo pembayaran piutang.</p>
            </div>
            <div class="mt-3 pt-2.5 border-t border-[#F0EFF6] flex items-center justify-between text-[10px] font-semibold">
              <span class="text-brandCoral font-bold">HPP & Laba: DITUTUP</span>
              <span class="text-teal-600">Hak: Portal Mandiri</span>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>

  <!-- Footer Info -->
  <div class="max-w-7xl mx-auto w-full text-center py-2 text-[11px] text-textMuted">
    &copy; {{ date('Y') }} Sistem Operasional Pasar Terpadu. Dibangun dengan Laravel 12 & Arsitektur Zero-Approval RBAC.
  </div>

  <!-- JavaScript Helper Functions -->
  <script>
    function togglePasswordVisibility() {
      const input = document.getElementById('passwordInput');
      const icon = document.getElementById('eyeIcon');
      if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
        `;
      } else {
        input.type = 'password';
        icon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        `;
      }
    }

    function fillCredential(username, password) {
      document.getElementById('usernameInput').value = username;
      document.getElementById('passwordInput').value = password;
    }

    function quickLoginRole(username, password) {
      fillCredential(username, password);
      // Auto-submit after filling
      document.getElementById('loginForm').submit();
    }
  </script>
</body>
</html>
