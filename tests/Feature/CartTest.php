<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_can_be_added_to_cart_when_stock_is_available(): void
    {
        $product = Product::factory()->create([
            'name' => 'Laptop',
            'price' => 999.99,
            'stock' => 5,
        ]);

        $response = $this->from('/shop')->post(route('cart.add', $product));

        $response->assertRedirect('/shop');
        $response->assertSessionHas('success');

        $this->assertSame([
            'name' => 'Laptop',
            'quantity' => 1,
            'price' => 999.99,
            'image' => null,
        ], session('cart.' . $product->id));
    }

    public function test_product_cannot_be_added_when_stock_is_unavailable(): void
    {
        $product = Product::factory()->create([
            'stock' => 0,
        ]);

        $response = $this->from('/shop')->post(route('cart.add', $product));

        $response->assertRedirect('/shop');
        $response->assertSessionHas('error', 'Not enough stock available.');
        $this->assertNull(session('cart'));
    }

    public function test_cart_quantity_cannot_exceed_product_stock(): void
    {
        $product = Product::factory()->create([
            'stock' => 2,
        ]);

        session()->put('cart', [
            $product->id => [
                'name' => $product->name,
                'quantity' => 2,
                'price' => $product->price,
                'image' => null,
            ],
        ]);

        $response = $this->from('/shop')->post(route('cart.add', $product));

        $response->assertRedirect('/shop');
        $response->assertSessionHas('error', 'Not enough stock available.');
        $this->assertSame(2, session('cart.' . $product->id . '.quantity'));
    }

    public function test_cart_quantity_can_be_updated_and_price_is_refreshed_from_database(): void
    {
        $product = Product::factory()->create([
            'price' => 100,
            'stock' => 10,
        ]);

        session()->put('cart', [
            $product->id => [
                'name' => 'Old name',
                'quantity' => 1,
                'price' => 50,
                'image' => null,
            ],
        ]);

        $product->update([
            'name' => 'Updated product',
            'price' => 120,
        ]);

        $response = $this->postJson(route('cart.update', $product->id), [
            'quantity' => 3,
        ]);

        $response->assertOk()->assertJson(['success' => true]);

        $this->assertSame(3, session('cart.' . $product->id . '.quantity'));
        $this->assertEquals(120, session('cart.' . $product->id . '.price'));
        $this->assertSame('Updated product', session('cart.' . $product->id . '.name'));
    }

    public function test_cart_update_rejects_quantity_above_stock(): void
    {
        $product = Product::factory()->create([
            'stock' => 2,
        ]);

        session()->put('cart', [
            $product->id => [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'image' => null,
            ],
        ]);

        $response = $this->postJson(route('cart.update', $product->id), [
            'quantity' => 3,
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Not enough stock available.',
            ]);

        $this->assertSame(1, session('cart.' . $product->id . '.quantity'));
    }

    public function test_cart_item_can_be_removed(): void
    {
        $product = Product::factory()->create();

        session()->put('cart', [
            $product->id => [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'image' => null,
            ],
        ]);

        $response = $this->from('/cart')->post(route('cart.remove', $product->id));

        $response->assertRedirect('/cart');
        $response->assertSessionHas('success');
        $this->assertNull(session('cart.' . $product->id));
    }
}
