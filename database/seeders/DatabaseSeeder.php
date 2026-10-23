<?php

namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with 8 PRD roles, initial settings, and audit trail.
     */
    public function run(): void
    {
        // 1. Seed 8 Accounts for 8 Roles
        $users = [
            [
                'name'          => 'Super Admin Sistem',
                'username'      => 'admin',
                'email'         => 'admin@pasarmodern.id',
                'password'      => Hash::make('password123'),
                'role'          => User::ROLE_SUPER_ADMIN,
                'location_id'   => 'TOKO_SENTRAL',
                'phone'         => '081234567890',
                'preferred_lang'=> 'id',
            ],
            [
                'name'          => 'Barbara Wijaya',
                'username'      => 'owner',
                'email'         => 'owner@pasarmodern.id',
                'password'      => Hash::make('password123'),
                'role'          => User::ROLE_OWNER,
                'location_id'   => 'TOKO_SENTRAL',
                'phone'         => '081234567891',
                'preferred_lang'=> 'id',
            ],
            [
                'name'          => 'Raka Pratama',
                'username'      => 'kepalatoko',
                'email'         => 'toko.lead@pasarmodern.id',
                'password'      => Hash::make('password123'),
                'role'          => User::ROLE_KEPALA_TOKO,
                'location_id'   => 'TOKO_SENTRAL',
                'phone'         => '081234567892',
                'preferred_lang'=> 'id',
            ],
            [
                'name'          => 'Bambang Hidayat',
                'username'      => 'kepalagudang',
                'email'         => 'gudang.lead@pasarmodern.id',
                'password'      => Hash::make('password123'),
                'role'          => User::ROLE_KEPALA_GUDANG,
                'location_id'   => 'GUDANG_PUSAT',
                'phone'         => '081234567893',
                'preferred_lang'=> 'id',
            ],
            [
                'name'          => 'Hendra Saputra',
                'username'      => 'stafgudang',
                'email'         => 'hendra@pasarmodern.id',
                'password'      => Hash::make('password123'),
                'role'          => User::ROLE_STAF_GUDANG,
                'location_id'   => 'GUDANG_PUSAT',
                'phone'         => '081234567894',
                'preferred_lang'=> 'id',
            ],
            [
                'name'          => 'Maya Sartika',
                'username'      => 'staftoko',
                'email'         => 'maya@pasarmodern.id',
                'password'      => Hash::make('password123'),
                'role'          => User::ROLE_STAF_TOKO,
                'location_id'   => 'TOKO_SENTRAL',
                'phone'         => '081234567895',
                'preferred_lang'=> 'id',
            ],
            [
                'name'          => 'Doni Pamungkas',
                'username'      => 'sales',
                'email'         => 'doni@pasarmodern.id',
                'password'      => Hash::make('password123'),
                'role'          => User::ROLE_SALES,
                'location_id'   => 'TOKO_SENTRAL',
                'phone'         => '081234567896',
                'preferred_lang'=> 'id',
            ],
            [
                'name'          => 'Haji Syahrul (CV Berkah Jaya)',
                'username'      => 'b2b',
                'email'         => 'syahrul@berkahjaya.com',
                'password'      => Hash::make('password123'),
                'role'          => User::ROLE_B2B,
                'location_id'   => 'MITRA_B2B',
                'phone'         => '081234567897',
                'preferred_lang'=> 'id',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['username' => $userData['username']],
                $userData
            );
        }

        // 2. Seed System Lock Parameters (PRD Section 4.2 & 4.4)
        $settings = [
            [
                'key'         => 'floor_price_margin_percent',
                'value'       => '10',
                'group'       => 'lock_parameters',
                'label'       => 'Margin Minimum Floor Price (%)',
                'description' => 'Batas bawah mutlak margin di atas HPP. Kasir POS terkunci otomatis jika input harga di bawah formula ini.',
            ],
            [
                'key'         => 'fuzzy_matching_threshold',
                'value'       => '75',
                'group'       => 'product_rules',
                'label'       => 'Ambang Deteksi Kemiripan Nama Produk (%)',
                'description' => 'Peringatan visual otomatis muncul saat membuat produk baru jika ditemukan kemiripan nama >= ambang ini.',
            ],
            [
                'key'         => 'default_b2b_credit_limit',
                'value'       => '50000000',
                'group'       => 'b2b_rules',
                'label'       => 'Plafon Kredit Standar B2B (Rp)',
                'description' => 'Plafon batas maksimal tempo piutang default untuk mitra B2B baru.',
            ],
            [
                'key'         => 'auto_block_overdue_days',
                'value'       => '30',
                'group'       => 'b2b_rules',
                'label'       => 'Maksimal Jatuh Tempo TOP (Hari)',
                'description' => 'Sistem otomatis menolak pesanan tempo jika ada tagihan yang melewati batas jatuh tempo ini.',
            ],
        ];

        foreach ($settings as $setting) {
            SystemSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        // 3. Seed Initial Audit Logs
        $admin = User::where('username', 'admin')->first();
        $raka = User::where('username', 'kepalatoko')->first();
        $hendra = User::where('username', 'stafgudang')->first();

        AuditLog::create([
            'user_id'       => $admin?->id,
            'username'      => 'admin',
            'role'          => User::ROLE_SUPER_ADMIN,
            'action'        => 'SYSTEM_INIT',
            'description'   => 'Inisialisasi sistem operasional pasar terpadu, konfigurasi parameter kunci dan matriks 8 role.',
            'data_snapshot' => ['version' => '1.0', 'status' => 'READY'],
            'ip_address'    => '127.0.0.1',
            'user_agent'    => 'System Seeder',
        ]);

        AuditLog::create([
            'user_id'       => $raka?->id,
            'username'      => 'kepalatoko',
            'role'          => User::ROLE_KEPALA_TOKO,
            'action'        => 'OPNAME_FINALIZED',
            'description'   => 'Finalisasi Stok Opname Toko Sentral: Selisih -Rp 74.000 pada Susu UHT 1L (-4 Pcs kemasan bocor).',
            'data_snapshot' => ['diff_qty' => -4, 'loss_rp' => 74000, 'reason' => 'Rusak/Bocor'],
            'ip_address'    => '127.0.0.1',
            'user_agent'    => 'Tablet Toko #01',
        ]);

        AuditLog::create([
            'user_id'       => $hendra?->id,
            'username'      => 'stafgudang',
            'role'          => User::ROLE_STAF_GUDANG,
            'action'        => 'RECEIVE_PO',
            'description'   => 'Penerimaan PO #PO-SUP-8921: 40 Karung Beras Pandan Wangi (2.000 Kg) lolos timbangan RFID Gate A1.',
            'data_snapshot' => ['po_number' => 'PO-SUP-8921', 'qty_sacks' => 40],
            'ip_address'    => '127.0.0.1',
            'user_agent'    => 'Scanner RFID Dock A1',
        ]);
    }
}
