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
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('navIndicator');
        $response->assertSee('mobileNavIndicator');
        $response->assertSee('id="page-0"', false);
        $response->assertSee('id="page-1"', false);
        $response->assertSee('id="page-2"', false);
        $response->assertSee('id="page-3"', false);
        $response->assertSee('id="page-4"', false);
        $response->assertSee('id="page-5"', false);
    }
}
