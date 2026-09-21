<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_admin_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_client_is_forbidden_from_admin_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'client',
        ]);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertForbidden();
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
    }

    public function test_client_is_forbidden_from_admin_product_routes(): void
    {
        $user = User::factory()->create([
            'role' => 'client',
        ]);

        $response = $this->actingAs($user)->get(route('admin.products.index'));

        $response->assertForbidden();
    }
}
