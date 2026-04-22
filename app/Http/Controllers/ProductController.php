<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request; // ⬅️ INI YANG SEBELUMNYA KURANG

class ProductController extends Controller
{
    public function show(Product $product)
    {
        // Load ulasan berserta nama user yang mereview, urutkan dari yang terbaru
        $product->load(['category', 'reviews.user' => function($q) {
            $q->latest();
        }]);
        
        // Mengambil produk serupa
        $related = Product::where('kategori_id', $product->kategori_id)
                    ->where('id', '!=', $product->id)
                    ->take(4)->get();

        return view('products.detail', compact('product', 'related'));
    }

    public function storeReview(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:500',
        ]);

        // Menyimpan ulasan ke database
        $product->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan kamu berhasil dikirim.');
    }
}