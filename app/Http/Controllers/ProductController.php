<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $product->load('category');
        $related = Product::where('kategori_id', $product->kategori_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.detail', compact('product', 'related'));
    }
}