<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['harga'] * $item['qty']);
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        if ($product->stok <= 0) {
            return back()->with('error', 'Stok ' . $product->nama_produk . ' habis.');
        }

        $cart = session()->get('cart', []);
        $qty = (int) $request->input('qty', 1);

        if (isset($cart[$product->id])) {
            $newQty = $cart[$product->id]['qty'] + $qty;
            if ($newQty > $product->stok) {
                return back()->with('error', 'Stok tidak mencukupi. Tersisa ' . $product->stok . ' pcs.');
            }
            $cart[$product->id]['qty'] = $newQty;
        } else {
            if ($qty > $product->stok) {
                return back()->with('error', 'Stok tidak mencukupi.');
            }
            $cart[$product->id] = [
                'id'       => $product->id,
                'nama'     => $product->nama_produk,
                'harga'    => $product->harga,
                'gambar'   => $product->url_gambar,
                'qty'      => $qty,
                'catatan'  => $request->input('catatan', ''),
                'stok'     => $product->stok,
                'fragile'  => $product->is_fragile,
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', $product->nama_produk . ' ditambahkan ke keranjang.');
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->input('id');
        $qty = (int) $request->input('qty');

        if (isset($cart[$id])) {
            if ($qty <= 0) {
                unset($cart[$id]);
            } else {
                if ($qty > $cart[$id]['stok']) {
                    return back()->with('error', 'Stok tidak mencukupi.');
                }
                $cart[$id]['qty'] = $qty;
            }
        }

        session()->put('cart', $cart);
        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        unset($cart[$request->input('id')]);
        session()->put('cart', $cart);
        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang dikosongkan.');
    }
}