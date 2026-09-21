<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class OrderTest extends TestCase
{
    public function test_order_accepts_expected_fillable_attributes(): void
    {
        $order = new Order([
            'user_id' => 1,
            'total_price' => 1499.99,
            'status' => 'pending',
            'address' => '10 Rue Hassan II',
            'city' => 'Rabat',
            'phone' => '0612345678',
        ]);

        $this->assertSame(1, $order->user_id);
        $this->assertSame(1499.99, $order->total_price);
        $this->assertSame('pending', $order->status);
        $this->assertSame('10 Rue Hassan II', $order->address);
        $this->assertSame('Rabat', $order->city);
        $this->assertSame('0612345678', $order->phone);
    }

    public function test_order_has_user_relationship(): void
    {
        $order = new Order();

        $relation = $order->user();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertSame(User::class, $relation->getRelated()::class);
        $this->assertSame('user_id', $relation->getForeignKeyName());
    }

    public function test_order_has_items_relationship(): void
    {
        $order = new Order();

        $relation = $order->items();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertSame(OrderItem::class, $relation->getRelated()::class);
        $this->assertSame('order_id', $relation->getForeignKeyName());
    }
}
