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

        // 4. Seed Suppliers (Fase 3)
        $suppliers = [
            [
                'code'               => 'SUP-TANI01',
                'name'               => 'PT Sumber Tani Nusantara',
                'contact_person'     => 'Bambang Sulistyo',
                'phone'              => '081122334455',
                'address'            => 'Sentra Pergudangan Beras KM 14, Karawang',
                'payment_terms_days' => 14,
                'category'           => 'Beras & Palawija',
            ],
            [
                'code'               => 'SUP-MINYAK02',
                'name'               => 'CV Agro Minyak Sejahtera',
                'contact_person'     => 'Dewi Lestari',
                'phone'              => '081233445566',
                'address'            => 'Kawasan Industri Rungkut Blok B4, Surabaya',
                'payment_terms_days' => 7,
                'category'           => 'Minyak & Bumbu',
            ],
            [
                'code'               => 'SUP-UNGGAS03',
                'name'               => 'Koperasi Peternak Unggas Berkah',
                'contact_person'     => 'H. Somad Qodir',
                'phone'              => '081344556677',
                'address'            => 'Desa Sukamulya RT 02/04, Blitar',
                'payment_terms_days' => 0, // Cash / Tunai
                'category'           => 'Telur & Unggas',
            ],
            [
                'code'               => 'SUP-SUSU04',
                'name'               => 'PT Industri Susu Sehat Nusantara',
                'contact_person'     => 'Vina Paramita',
                'phone'              => '081566778899',
                'address'            => 'Jl. Raya Cipanas No. 88, Bogor',
                'payment_terms_days' => 30,
                'category'           => 'Susu & Olahan',
            ],
        ];

        $createdSuppliers = [];
        foreach ($suppliers as $sup) {
            $createdSuppliers[$sup['code']] = \App\Models\Supplier::updateOrCreate(
                ['code' => $sup['code']],
                $sup
            );
        }

        // 5. Seed Products & Multi-Satuan (UOM) (Fase 3)
        $productsData = [
            [
                'sku'                => 'SKU-AD10',
                'barcode'            => '899123456001',
                'name'               => 'Beras Anak Daro Premium',
                'category'           => 'Beras & Palawija',
                'base_uom'           => 'Kg',
                'current_hpp'        => 14500,
                'floor_price_margin' => 10.0,
                'min_market_price'   => 16000,
                'max_market_price'   => 17500,
                'stock_gudang'       => 2500,
                'stock_toko'         => 500,
                'min_stock_alert'    => 200,
                'supplier_id'        => $createdSuppliers['SUP-TANI01']->id,
                'description'        => 'Beras pulen khas Solok kualitas super, butiran utuh bebas pemutih.',
                'units'              => [
                    ['uom_name' => 'Karung 50Kg', 'conversion_factor' => 50, 'selling_price' => 790000, 'barcode' => '899123456001-K50', 'is_default_purchase' => true],
                    ['uom_name' => 'Karung 25Kg', 'conversion_factor' => 25, 'selling_price' => 400000, 'barcode' => '899123456001-K25', 'is_default_purchase' => false],
                    ['uom_name' => 'Pack 5Kg', 'conversion_factor' => 5, 'selling_price' => 82500, 'barcode' => '899123456001-P5', 'is_default_purchase' => false],
                ],
            ],
            [
                'sku'                => 'SKU-PW50',
                'barcode'            => '899123456002',
                'name'               => 'Beras Pandan Wangi Cianjur',
                'category'           => 'Beras & Palawija',
                'base_uom'           => 'Kg',
                'current_hpp'        => 15000,
                'floor_price_margin' => 10.0,
                'min_market_price'   => 16800,
                'max_market_price'   => 18500,
                'stock_gudang'       => 4000,
                'stock_toko'         => 800,
                'min_stock_alert'    => 300,
                'supplier_id'        => $createdSuppliers['SUP-TANI01']->id,
                'description'        => 'Beras aromatik khas Jawa Barat, wangi pandan alami dan tekstur lembut.',
                'units'              => [
                    ['uom_name' => 'Karung 50Kg', 'conversion_factor' => 50, 'selling_price' => 825000, 'barcode' => '899123456002-K50', 'is_default_purchase' => true],
                    ['uom_name' => 'Karung 25Kg', 'conversion_factor' => 25, 'selling_price' => 420000, 'barcode' => '899123456002-K25', 'is_default_purchase' => false],
                ],
            ],
            [
                'sku'                => 'SKU-MG02',
                'barcode'            => '899123456003',
                'name'               => 'Minyak Goreng Sawit 2 Liter',
                'category'           => 'Minyak & Bumbu',
                'base_uom'           => 'Pouch',
                'current_hpp'        => 31000,
                'floor_price_margin' => 10.0,
                'min_market_price'   => 34500,
                'max_market_price'   => 37000,
                'stock_gudang'       => 600,
                'stock_toko'         => 120,
                'min_stock_alert'    => 50,
                'supplier_id'        => $createdSuppliers['SUP-MINYAK02']->id,
                'description'        => 'Minyak goreng kelapa sawit bening 2x penyaringan, kemasan pouch higienis.',
                'units'              => [
                    ['uom_name' => 'Dus 6Pouch', 'conversion_factor' => 6, 'selling_price' => 205000, 'barcode' => '899123456003-D6', 'is_default_purchase' => true],
                ],
            ],
            [
                'sku'                => 'SKU-TL01',
                'barcode'            => '899123456004',
                'name'               => 'Telur Ayam Negeri Fresh',
                'category'           => 'Telur & Unggas',
                'base_uom'           => 'Kg',
                'current_hpp'        => 25500,
                'floor_price_margin' => 8.0,
                'min_market_price'   => 28000,
                'max_market_price'   => 31000,
                'stock_gudang'       => 300,
                'stock_toko'         => 150,
                'min_stock_alert'    => 50,
                'supplier_id'        => $createdSuppliers['SUP-UNGGAS03']->id,
                'description'        => 'Telur ayam ras peternakan segar tiap pagi, cangkang tebal bebas retak.',
                'units'              => [
                    ['uom_name' => 'Peti 15Kg', 'conversion_factor' => 15, 'selling_price' => 415000, 'barcode' => '899123456004-P15', 'is_default_purchase' => true],
                ],
            ],
            [
                'sku'                => 'SKU-SU01',
                'barcode'            => '899123456005',
                'name'               => 'Susu UHT Full Cream 1 Liter',
                'category'           => 'Susu & Olahan',
                'base_uom'           => 'Kotak',
                'current_hpp'        => 17500,
                'floor_price_margin' => 12.0,
                'min_market_price'   => 20000,
                'max_market_price'   => 22500,
                'stock_gudang'       => 480,
                'stock_toko'         => 96,
                'min_stock_alert'    => 40,
                'supplier_id'        => $createdSuppliers['SUP-SUSU04']->id,
                'description'        => 'Susu segar UHT rasa gurih kaya kalsium kemasan aseptic tetrapak.',
                'units'              => [
                    ['uom_name' => 'Karton 12Kotak', 'conversion_factor' => 12, 'selling_price' => 238000, 'barcode' => '899123456005-K12', 'is_default_purchase' => true],
                ],
            ],
        ];

        foreach ($productsData as $pData) {
            $units = $pData['units'] ?? [];
            unset($pData['units']);

            $product = \App\Models\Product::updateOrCreate(
                ['sku' => $pData['sku']],
                $pData
            );

            // Re-seed units
            $product->units()->delete();
            foreach ($units as $u) {
                $product->units()->create($u);
            }
        }
    }
}
