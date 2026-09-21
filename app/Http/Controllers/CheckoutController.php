<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty!');
        }

        return view('client.checkout', compact('cart'));
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'address' => ['required', 'string', 'max:1000'],
            'city' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty!');
        }

        try {
            DB::transaction(function () use ($validated, $cart) {
                $productIds = array_keys($cart);
                $products = Product::whereIn('id', $productIds)
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                $total = 0;

                foreach ($cart as $productId => $item) {
                    $product = $products->get((int) $productId);
                    $quantity = (int) ($item['quantity'] ?? 0);

                    if (!$product || $quantity < 1) {
                        throw new \RuntimeException('A product in your cart is no longer available.');
                    }

                    if ($quantity > $product->stock) {
                        throw new \RuntimeException("Not enough stock available for {$product->name}.");
                    }

                    $total += (float) $product->price * $quantity;
                }

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'total_price' => $total,
                    'status' => 'pending',
                    'address' => $validated['address'],
                    'city' => $validated['city'],
                    'phone' => $validated['phone'],
                ]);

                foreach ($cart as $productId => $item) {
                    $product = $products->get((int) $productId);
                    $quantity = (int) $item['quantity'];

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $product->price,
                    ]);

                    $product->decrement('stock', $quantity);
                }
            });
        } catch (\RuntimeException $exception) {
            return redirect()
                ->route('cart.index')
                ->with('error', $exception->getMessage());
        }

        session()->forget('cart');

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order placed successfully!');
    }
}
