<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
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
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->route('shop.index');

        $request->validate([
            'address' => 'required',
            'city' => 'required',
            'phone' => 'required',
        ]);

        $total = 0;
        foreach ($cart as $item) $total += $item['price'] * $item['quantity'];

        $discount = 0;
        if (session()->has('coupon')) {
            $cp = session('coupon');
            if ($cp['type'] == 'fixed') $discount = $cp['value'];
            else $discount = ($total * $cp['value']) / 100;
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => max(0, $total - $discount),
            'status' => 'pending',
            'address' => $request->address,
            'city' => $request->city,
            'phone' => $request->phone
        ]);

        foreach ($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $details['quantity'],
                'price' => $details['price']
            ]);
        }

        session()->forget(['cart', 'coupon']);
        return redirect()->route('orders.index')->with('success', 'Commande validée !');
    }
}
