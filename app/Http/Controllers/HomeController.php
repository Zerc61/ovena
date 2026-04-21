<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
 public function index()
{
    $categories = Category::withCount('products')->get();

    $products = Product::with('category')
        ->when(request('search'), fn($q, $s) =>
            $q->where('nama_produk', 'like', "%{$s}%")
        )
        ->when(request('kategori'), fn($q, $k) =>
            $q->where('kategori_id', $k)
        )
        ->latest()
        ->paginate(12)
        ->withQueryString();

    // Best seller — hanya query kalau ada data order_details
    $bestSellers = collect();

    $bestSellerIds = \App\Models\OrderDetail::select('product_id')
        ->selectRaw('SUM(kuantitas) as total_sold')
        ->groupBy('product_id')
        ->orderByDesc('total_sold')
        ->limit(4)
        ->pluck('product_id');

    if ($bestSellerIds->isNotEmpty()) {
        $bestSellers = Product::whereIn('id', $bestSellerIds)
            ->orderByRaw("FIELD(id, {$bestSellerIds->implode(',')})")
            ->get();
    }

    return view('home', compact('categories', 'products', 'bestSellers'));
}
}