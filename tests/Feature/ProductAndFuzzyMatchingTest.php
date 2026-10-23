<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Supplier;
use App\Models\User;
use App\Services\ProductFuzzyMatcher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductAndFuzzyMatchingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    /**
     * Test 1: Fuzzy Matching detects potential duplicate products >= 75%.
     */
    public function test_fuzzy_matcher_detects_high_similarity_duplicates(): void
    {
        // Existing in seeder: "Beras Anak Daro Premium"
        $variations = [
            'Beras Anak Daro',
            'Beras Anak Daro 10 Kg',
            'Beras Anak Daro Premium 50Kg',
            'Beras Anak Daro Super',
        ];

        foreach ($variations as $name) {
            $result = ProductFuzzyMatcher::checkSimilarity($name);
            $this->assertTrue($result['has_duplicate_risk'], "Name '{$name}' should trigger duplicate warning.");
            $this->assertGreaterThanOrEqual(75.0, $result['highest_similarity']);
            $this->assertNotEmpty($result['matches']);
        }
    }

    /**
     * Test 2: Fuzzy Matching allows distinctly different product names without warning.
     */
    public function test_fuzzy_matcher_allows_distinct_products(): void
    {
        $distinctNames = [
            'Kopi Bubuk Robusta Lampung',
            'Kecap Manis Cap Bango 550ml',
            'Garam Beryodium Halus 250gr',
        ];

        foreach ($distinctNames as $name) {
            $result = ProductFuzzyMatcher::checkSimilarity($name);
            $this->assertFalse($result['has_duplicate_risk'], "Distinct name '{$name}' should NOT trigger duplicate warning.");
        }
    }

    /**
     * Test 3: API endpoint /products/fuzzy-check responds with valid JSON payload.
     */
    public function test_api_fuzzy_check_endpoint(): void
    {
        $admin = User::where('role', User::ROLE_SUPER_ADMIN)->first();
        $this->actingAs($admin);

        $response = $this->postJson(route('products.fuzzy-check'), [
            'name' => 'Beras Anak Daro',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'has_duplicate_risk',
            'threshold',
            'highest_similarity',
            'matches',
        ]);
        $this->assertTrue($response->json('has_duplicate_risk'));
    }

    /**
     * Test 4: Create Product along with multi-satuan (ProductUnit) tiered conversions.
     */
    public function test_can_create_product_with_multi_tiered_units(): void
    {
        $gudangLead = User::where('role', User::ROLE_KEPALA_GUDANG)->first();
        $this->actingAs($gudangLead);

        $supplier = Supplier::first();

        $payload = [
            'name'               => 'Kacang Hijau Kupas Super',
            'category'           => 'Beras & Palawija',
            'base_uom'           => 'Kg',
            'current_hpp'        => 22000,
            'floor_price_margin' => 10,
            'min_market_price'   => 25000,
            'max_market_price'   => 28000,
            'stock_gudang'       => 500,
            'stock_toko'         => 100,
            'supplier_id'        => $supplier->id,
            'units'              => [
                [
                    'uom_name'          => 'Karung 25Kg',
                    'conversion_factor' => 25,
                    'selling_price'     => 600000,
                    'barcode'           => '899-KH-K25',
                ],
                [
                    'uom_name'          => 'Pack 1Kg',
                    'conversion_factor' => 1,
                    'selling_price'     => 26000,
                    'barcode'           => '899-KH-P1',
                ],
            ],
        ];

        $response = $this->post(route('products.store'), $payload);
        $response->assertRedirect();

        $product = Product::where('name', 'Kacang Hijau Kupas Super')->first();
        $this->assertNotNull($product);
        $this->assertNotEmpty($product->sku);
        $this->assertEquals(24200.0, $product->getFloorPrice()); // 22000 + 10%
        $this->assertEquals(2, $product->units()->count());

        // Test tiered stock breakdown formatting
        $formatted = $product->getFormattedStock(75);
        $this->assertStringContainsString('Karung 25Kg', $formatted);
    }

    /**
     * Test 5: Supplier CRUD operates correctly.
     */
    public function test_supplier_crud_operations(): void
    {
        $admin = User::where('role', User::ROLE_SUPER_ADMIN)->first();
        $this->actingAs($admin);

        $payload = [
            'name'               => 'UD Sayur Segar Lembang',
            'code'               => 'SUP-SAYUR99',
            'contact_person'     => 'Kang Asep',
            'phone'              => '081999888777',
            'address'            => 'Lembang, Bandung Barat',
            'payment_terms_days' => 3,
            'category'           => 'Sayur & Buah Segar',
        ];

        $response = $this->post(route('suppliers.store'), $payload);
        $response->assertRedirect();

        $supplier = Supplier::where('code', 'SUP-SAYUR99')->first();
        $this->assertNotNull($supplier);
        $this->assertEquals('Tempo 3 Hari', $supplier->getTermsLabel());

        // Update Supplier
        $updateResponse = $this->put(route('suppliers.update', $supplier), [
            'name'               => 'UD Sayur Segar Lembang (Revisi)',
            'code'               => 'SUP-SAYUR99',
            'contact_person'     => 'Kang Asep Mulyana',
            'phone'              => '081999888777',
            'address'            => 'Lembang, Bandung Barat',
            'payment_terms_days' => 7,
            'category'           => 'Sayur & Buah Segar',
            'is_active'          => true,
        ]);

        $updateResponse->assertRedirect();
        $this->assertEquals('Tempo 7 Hari', $supplier->fresh()->getTermsLabel());
    }

    /**
     * Test 6: Owner is strictly Read-Only and blocked from creating products and suppliers.
     */
    public function test_owner_is_blocked_from_creating_products_and_suppliers(): void
    {
        $owner = User::where('role', User::ROLE_OWNER)->first();
        $this->actingAs($owner);

        // Attempt product store
        $productResponse = $this->post(route('products.store'), [
            'name'             => 'Produk Coba Owner',
            'category'         => 'Sembako',
            'base_uom'         => 'Kg',
            'current_hpp'      => 10000,
            'min_market_price' => 12000,
            'max_market_price' => 15000,
        ]);

        if ($productResponse->status() === 302) {
            $productResponse->assertSessionHas('error');
        } else {
            $productResponse->assertStatus(403);
        }

        // Attempt supplier store
        $supplierResponse = $this->post(route('suppliers.store'), [
            'name'               => 'Suplayer Coba Owner',
            'phone'              => '081234',
            'payment_terms_days' => 0,
        ]);

        if ($supplierResponse->status() === 302) {
            $supplierResponse->assertSessionHas('error');
        } else {
            $supplierResponse->assertStatus(403);
        }
    }
}
