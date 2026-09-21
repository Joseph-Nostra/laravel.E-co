<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function test_category_accepts_expected_fillable_attributes(): void
    {
        $category = new Category([
            'name' => 'Informatique',
            'description' => 'Produits informatiques.',
            'image' => 'informatique.jpg',
        ]);

        $this->assertSame('Informatique', $category->name);
        $this->assertSame('Produits informatiques.', $category->description);
        $this->assertSame('informatique.jpg', $category->image);
    }

    public function test_category_has_products_relationship(): void
    {
        $category = new Category();

        $relation = $category->products();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertSame(Product::class, $relation->getRelated()::class);
        $this->assertSame('category_id', $relation->getForeignKeyName());
    }
}
