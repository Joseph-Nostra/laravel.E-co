<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Review;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function test_product_accepts_expected_fillable_attributes(): void
    {
        $product = new Product([
            'name' => 'Laptop',
            'slug' => 'laptop',
            'description' => 'A test product.',
            'price' => 999.99,
            'stock' => 10,
            'category_id' => 1,
        ]);

        $this->assertSame('Laptop', $product->name);
        $this->assertSame('laptop', $product->slug);
        $this->assertSame('A test product.', $product->description);
        $this->assertSame(999.99, $product->price);
        $this->assertSame(10, $product->stock);
        $this->assertSame(1, $product->category_id);
    }

    public function test_product_has_category_relationship(): void
    {
        $product = new Product();

        $this->assertInstanceOf(BelongsTo::class, $product->category());
        $this->assertSame(Category::class, $product->category()->getRelated()::class);
    }

    public function test_product_has_expected_has_many_relationships(): void
    {
        $product = new Product();

        $this->assertInstanceOf(HasMany::class, $product->images());
        $this->assertSame(ProductImage::class, $product->images()->getRelated()::class);

        $this->assertInstanceOf(HasMany::class, $product->orderItems());
        $this->assertSame(OrderItem::class, $product->orderItems()->getRelated()::class);

        $this->assertInstanceOf(HasMany::class, $product->reviews());
        $this->assertSame(Review::class, $product->reviews()->getRelated()::class);

        $this->assertInstanceOf(HasMany::class, $product->wishlists());
        $this->assertSame(Wishlist::class, $product->wishlists()->getRelated()::class);
    }
}
