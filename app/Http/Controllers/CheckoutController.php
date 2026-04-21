<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect('/cart')->with('error', 'Keranjang kosong.');

        $total = collect($cart)->sum(fn($item) => $item['harga'] * $item['qty']);
        $user = auth()->user();

        return view('checkout.index', compact('cart', 'total', 'user'));
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect('/cart')->with('error', 'Keranjang kosong.');

        $validated = $request->validate([
            'nama_penerima'   => 'required|string|max:100',
            'no_telp_penerima'=> 'required|string|max:20',
            'alamat_pengiriman'=> 'required|string',
            'metode_pembayaran'=> 'required|in:transfer,ewallet,cod,qris',
            'catatan'          => 'nullable|string',
        ]);

        $total = collect($cart)->sum(fn($item) => $item['harga'] * $item['qty']);

        $order = DB::transaction(function () use ($cart, $total, $validated) {
            $order = Order::create([
                'user_id'           => auth()->id(),
                'total_harga'       => $total,
                'status'            => 'pending',
                'nama_penerima'     => $validated['nama_penerima'],
                'no_telp_penerima'  => $validated['no_telp_penerima'],
                'alamat_pengiriman' => $validated['alamat_pengiriman'],
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'catatan'           => $validated['catatan'] ?? null,
            ]);

            foreach ($cart as $item) {
                OrderDetail::create([
                    'order_id'       => $order->id,
                    'product_id'     => $item['id'],
                    'kuantitas'      => $item['qty'],
                    'harga_satuan'   => $item['harga'],
                    'catatan_khusus' => $item['catatan'] ?? null,
                ]);

                // Kurangi stok
                \App\Models\Product::where('id', $item['id'])
                    ->decrement('stok', $item['qty']);
            }

            return $order;
        });

        session()->forget('cart');
        return redirect()->route('payment.show', $order->id)
            ->with('success', 'Pesanan berhasil dibuat!');
    }
}