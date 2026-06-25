<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = Wishlist::with('product.images')->where('user_id', Auth::id())->get();
        return view('client.wishlist', compact('wishlist'));
    }

    public function toggle(Product $product)
    {
        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($exists) {
            $exists->delete();
            return response()->json(['status' => 'removed']);
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id
        ]);

        return response()->json(['status' => 'added']);
    }
}
