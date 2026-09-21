<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProductTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_view_products_page(): void
    {
        $response = $this->actingAs($this->admin())
            ->get(route('admin.products.index'));

        $response->assertOk();
    }

    public function test_admin_can_create_product(): void
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin())
            ->post(route('admin.products.store'), [
                'name' => 'Gaming Laptop',
                'description' => 'Powerful laptop.',
                'price' => 1499.99,
                'category_id' => $category->id,
                'stock' => 10,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Product created successfully');

        $this->assertDatabaseHas('products', [
            'name' => 'Gaming Laptop',
            'slug' => 'gaming-laptop',
            'price' => 1499.99,
            'category_id' => $category->id,
            'stock' => 10,
        ]);
    }

    public function test_product_creation_validates_required_fields(): void
    {
        $response = $this->actingAs($this->admin())
            ->post(route('admin.products.store'), []);

        $response->assertSessionHasErrors([
            'name',
            'price',
            'category_id',
            'stock',
        ]);

        $this->assertDatabaseCount('products', 0);
    }

    public function test_product_creation_rejects_invalid_category(): void
    {
        $response = $this->actingAs($this->admin())
            ->post(route('admin.products.store'), [
                'name' => 'Laptop',
                'price' => 100,
                'category_id' => 99999,
                'stock' => 5,
            ]);

        $response->assertSessionHasErrors(['category_id']);
        $this->assertDatabaseCount('products', 0);
    }

    public function test_admin_can_update_product(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'name' => 'Old Laptop',
            'category_id' => $category->id,
            'price' => 500,
            'stock' => 2,
        ]);

        $response = $this->actingAs($this->admin())
            ->put(route('admin.products.update', $product), [
                'name' => 'New Laptop',
                'description' => 'Updated description.',
                'price' => 750,
                'category_id' => $category->id,
                'stock' => 8,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Product updated successfully');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'New Laptop',
            'slug' => 'new-laptop',
            'price' => 750,
            'stock' => 8,
        ]);
    }

    public function test_admin_can_delete_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->admin())
            ->delete(route('admin.products.destroy', $product));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Product deleted successfully');
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_client_cannot_create_product(): void
    {
        $category = Category::factory()->create();

        $response = $this->actingAs(
            User::factory()->create(['role' => 'client'])
        )->post(route('admin.products.store'), [
            'name' => 'Unauthorized Product',
            'price' => 100,
            'category_id' => $category->id,
            'stock' => 5,
        ]);

        $response->assertForbidden();
        $this->assertDatabaseCount('products', 0);
    }
}
