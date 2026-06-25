<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function autocomplete(Request $request)
    {
        $query = $request->get('q');
        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->take(5)
            ->get(['id', 'name', 'slug', 'price']);

        return response()->json($products);
    }
}
