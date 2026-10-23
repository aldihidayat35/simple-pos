<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\SystemSetting;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthAndRbacTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Seed database for testing
        $this->artisan('db:seed');
    }

    /**
     * Test 1: Verify all 8 roles exist and can log in with password123.
     */
    public function test_all_eight_roles_can_login_successfully(): void
    {
        $roles = [
            'admin',
            'owner',
            'kepalatoko',
            'kepalagudang',
            'stafgudang',
            'staftoko',
            'sales',
            'b2b',
        ];

        foreach ($roles as $username) {
            $response = $this->post(route('login.submit'), [
                'username' => $username,
                'password' => 'password123',
            ]);

            $response->assertRedirect(route('dashboard'));
            $this->assertAuthenticated();

            // Logout for next role
            $this->post(route('logout'));
            $this->assertGuest();
        }
    }

    /**
     * Test 2: Verify HPP & Gross Profit access matrix for 8 roles.
     */
    public function test_hpp_and_profit_access_matrix(): void
    {
        // 4 Roles with HPP Access
        $allowedRoles = [
            User::ROLE_SUPER_ADMIN,
            User::ROLE_OWNER,
            User::ROLE_KEPALA_TOKO,
            User::ROLE_KEPALA_GUDANG,
        ];

        foreach ($allowedRoles as $role) {
            $user = User::where('role', $role)->first();
            $this->assertNotNull($user);
            $this->assertTrue($user->canViewHpp(), "Role {$role} should have HPP access.");
            $this->assertTrue($user->canViewProfit(), "Role {$role} should have Profit access.");
        }

        // 4 Roles with HPP HIDDEN
        $restrictedRoles = [
            User::ROLE_STAF_GUDANG,
            User::ROLE_STAF_TOKO,
            User::ROLE_SALES,
            User::ROLE_B2B,
        ];

        foreach ($restrictedRoles as $role) {
            $user = User::where('role', $role)->first();
            $this->assertNotNull($user);
            $this->assertFalse($user->canViewHpp(), "Role {$role} MUST NOT have HPP access.");
            $this->assertFalse($user->canViewProfit(), "Role {$role} MUST NOT have Profit access.");
        }
    }

    /**
     * Test 3: Verify Owner is strictly Read-Only and blocked from data mutations.
     */
    public function test_owner_is_read_only_and_blocked_from_mutations(): void
    {
        $owner = User::where('role', User::ROLE_OWNER)->first();
        $this->actingAs($owner);

        $this->assertTrue($owner->isReadOnly());

        // Attempting to update system settings as Owner must be blocked by EnsureReadOnly
        $response = $this->post(route('admin.settings.update'), [
            'floor_price_margin_percent' => 15,
            'fuzzy_matching_threshold' => 80,
            'default_b2b_credit_limit' => 60000000,
            'auto_block_overdue_days' => 14,
        ]);

        // Intercepted with 403 or redirect with error
        if ($response->status() === 302) {
            $response->assertSessionHas('error');
        } else {
            $response->assertStatus(403);
        }
    }

    /**
     * Test 4: Super Admin can access admin management and update system settings.
     */
    public function test_super_admin_can_manage_users_and_settings(): void
    {
        $admin = User::where('role', User::ROLE_SUPER_ADMIN)->first();
        $this->actingAs($admin);

        // Access admin dashboard
        $response = $this->get(route('admin.users'));
        $response->assertStatus(200);
        $response->assertSee('Panel Super Admin');

        // Update system settings
        $updateResponse = $this->post(route('admin.settings.update'), [
            'floor_price_margin_percent' => 12.5,
            'fuzzy_matching_threshold' => 80,
            'default_b2b_credit_limit' => 75000000,
            'auto_block_overdue_days' => 25,
        ]);

        $updateResponse->assertRedirect();
        $this->assertEquals('12.5', SystemSetting::getVal('floor_price_margin_percent'));
    }

    /**
     * Test 5: AuditLogger automatically writes entries with user context and snapshots.
     */
    public function test_audit_logger_records_mutations(): void
    {
        $admin = User::where('role', User::ROLE_SUPER_ADMIN)->first();
        $this->actingAs($admin);

        $initialCount = AuditLog::count();

        AuditLogger::log(
            action: 'TEST_ACTION',
            description: 'Uji coba pencatatan audit log',
            model: $admin,
            newValues: ['test_key' => 'test_val']
        );

        $this->assertEquals($initialCount + 1, AuditLog::count());

        $latestLog = AuditLog::orderBy('id', 'desc')->first();
        $this->assertEquals('TEST_ACTION', $latestLog->action);
        $this->assertEquals($admin->id, $latestLog->user_id);
        $this->assertEquals(User::ROLE_SUPER_ADMIN, $latestLog->role);
        $this->assertNotNull($latestLog->new_values);
    }

    /**
     * Test 6: Role Switcher operates seamlessly.
     */
    public function test_role_switcher_swaps_active_session(): void
    {
        $admin = User::where('role', User::ROLE_SUPER_ADMIN)->first();
        $this->actingAs($admin);

        $response = $this->post(route('auth.switch-role'), [
            'role' => User::ROLE_STAF_TOKO,
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertEquals(User::ROLE_STAF_TOKO, auth()->user()->role);
    }
}
