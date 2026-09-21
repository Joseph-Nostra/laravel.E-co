<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrderStatusTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    private function order(): Order
    {
        return Order::create([
            'user_id' => User::factory()->create(['role' => 'client'])->id,
            'total_price' => 199.99,
            'status' => 'pending',
            'address' => '10 Rue Hassan II',
            'city' => 'Rabat',
            'phone' => '0612345678',
        ]);
    }

    public function test_admin_can_update_order_status(): void
    {
        $order = $this->order();

        $response = $this->actingAs($this->admin())
            ->post(route('admin.orders.status', $order), [
                'status' => 'confirmed',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Order status updated');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'confirmed',
        ]);
    }

    public function test_admin_can_set_each_valid_order_status(): void
    {
        foreach (['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'] as $status) {
            $order = $this->order();

            $response = $this->actingAs($this->admin())
                ->post(route('admin.orders.status', $order), [
                    'status' => $status,
                ]);

            $response->assertRedirect();

            $this->assertDatabaseHas('orders', [
                'id' => $order->id,
                'status' => $status,
            ]);
        }
    }

    public function test_order_status_is_required(): void
    {
        $order = $this->order();

        $response = $this->actingAs($this->admin())
            ->post(route('admin.orders.status', $order), []);

        $response->assertSessionHasErrors(['status']);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'pending',
        ]);
    }

    public function test_invalid_order_status_is_rejected(): void
    {
        $order = $this->order();

        $response = $this->actingAs($this->admin())
            ->post(route('admin.orders.status', $order), [
                'status' => 'paid',
            ]);

        $response->assertSessionHasErrors(['status']);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'pending',
        ]);
    }

    public function test_client_cannot_update_order_status(): void
    {
        $order = $this->order();

        $response = $this->actingAs(
            User::factory()->create(['role' => 'client'])
        )->post(route('admin.orders.status', $order), [
            'status' => 'confirmed',
        ]);

        $response->assertForbidden();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'pending',
        ]);
    }

    public function test_guest_cannot_update_order_status(): void
    {
        $order = $this->order();

        $response = $this->post(route('admin.orders.status', $order), [
            'status' => 'confirmed',
        ]);

        $response->assertRedirect(route('login'));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'pending',
        ]);
    }
}
