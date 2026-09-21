<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('client.cart', compact('cart'));
    }

    public function add(Product $product, Request $request)
    {
        $cart = session()->get('cart', []);
        $currentQuantity = $cart[$product->id]['quantity'] ?? 0;

        if ($product->stock < $currentQuantity + 1) {
            return redirect()->back()->with('error', 'Not enough stock available.');
        }

        $cart[$product->id] = [
            'name' => $product->name,
            'quantity' => $currentQuantity + 1,
            'price' => $product->price,
            'image' => $product->images->first()->image ?? null,
        ];

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($id);

        if ($validated['quantity'] > $product->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock available.',
            ], 422);
        }

        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return response()->json([
                'success' => false,
                'message' => 'Product is not in the cart.',
            ], 404);
        }

        $cart[$id]['quantity'] = $validated['quantity'];
        $cart[$id]['price'] = $product->price;
        $cart[$id]['name'] = $product->name;

        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }

    public function remove(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product removed successfully!');
    }
}
