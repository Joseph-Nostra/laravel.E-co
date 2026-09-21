<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_complete_checkout(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'price' => 100,
            'stock' => 5,
        ]);

        $this->actingAs($user);

        session()->put('cart', [
            $product->id => [
                'name' => $product->name,
                'quantity' => 2,
                'price' => 1,
                'image' => null,
            ],
        ]);

        $response = $this->post(route('checkout.process'), [
            'address' => '10 Rue Hassan II',
            'city' => 'Rabat',
            'phone' => '0612345678',
        ]);

        $response->assertRedirect(route('orders.index'));
        $response->assertSessionHas('success', 'Order placed successfully!');
        $this->assertNull(session('cart'));

        $order = Order::first();

        $this->assertNotNull($order);
        $this->assertSame($user->id, $order->user_id);
        $this->assertEquals(200, $order->total_price);
        $this->assertSame('pending', $order->status);

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 100,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 3,
        ]);
    }

    public function test_checkout_rejects_quantity_above_stock_without_creating_order(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'price' => 100,
            'stock' => 1,
        ]);

        $this->actingAs($user);

        session()->put('cart', [
            $product->id => [
                'name' => $product->name,
                'quantity' => 2,
                'price' => 1,
                'image' => null,
            ],
        ]);

        $response = $this->post(route('checkout.process'), [
            'address' => '10 Rue Hassan II',
            'city' => 'Rabat',
            'phone' => '0612345678',
        ]);

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('error', 'Not enough stock available for ' . $product->name . '.');

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('order_items', 0);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 1,
        ]);
        $this->assertNotNull(session('cart'));
    }

    public function test_checkout_uses_database_price_instead_of_cart_price(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'price' => 250,
            'stock' => 10,
        ]);

        $this->actingAs($user);

        session()->put('cart', [
            $product->id => [
                'name' => $product->name,
                'quantity' => 2,
                'price' => 0.01,
                'image' => null,
            ],
        ]);

        $response = $this->post(route('checkout.process'), [
            'address' => '10 Rue Hassan II',
            'city' => 'Rabat',
            'phone' => '0612345678',
        ]);

        $response->assertRedirect(route('orders.index'));

        $order = Order::first();
        $item = OrderItem::first();

        $this->assertEquals(500, $order->total_price);
        $this->assertEquals(250, $item->price);
        $this->assertNull(session('cart'));
    }

    public function test_checkout_requires_shipping_information(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        session()->put('cart', [
            1 => [
                'name' => 'Product',
                'quantity' => 1,
                'price' => 100,
                'image' => null,
            ],
        ]);

        $response = $this->post(route('checkout.process'), []);

        $response->assertSessionHasErrors(['address', 'city', 'phone']);
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_guest_cannot_process_checkout(): void
    {
        $response = $this->post(route('checkout.process'), [
            'address' => '10 Rue Hassan II',
            'city' => 'Rabat',
            'phone' => '0612345678',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseCount('orders', 0);
    }
}
