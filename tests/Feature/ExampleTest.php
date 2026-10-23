<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $user = \App\Models\User::first();

        // 1. Dashboard Route
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
        $response->assertSee('navIndicator');
        $response->assertSee('mobileNavIndicator');

        // 2. Warehouse Route
        $responseWh = $this->actingAs($user)->get('/warehouse');
        $responseWh->assertStatus(200);
        $responseWh->assertSee('Gudang Pusat');

        // 3. POS Route
        $responsePos = $this->actingAs($user)->get('/pos');
        $responsePos->assertStatus(200);
        $responsePos->assertSee('Kasir');

        // 4. B2B Route
        $responseB2b = $this->actingAs($user)->get('/b2b');
        $responseB2b->assertStatus(200);
        $responseB2b->assertSee('Kemitraan Grosir B2B');

        // 5. Audit Trail Route
        $responseAudit = $this->actingAs($user)->get('/audit-logs');
        $responseAudit->assertStatus(200);
        $responseAudit->assertSee('Audit Trail');

        // 6. Products Route
        $responseProd = $this->actingAs($user)->get('/products');
        $responseProd->assertStatus(200);
        $responseProd->assertSee('Master Produk');
    }
}
