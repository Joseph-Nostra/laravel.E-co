<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('category', 'images')->take(8)->get();
        $categories = Category::all();
        return view('client.home', compact('featuredProducts', 'categories'));
    }

    public function orders()
    {
        $orders = Auth::user()->orders()->with('items.product')->latest()->get();
        return view('client.orders', compact('orders'));
    }
}
