<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()
            ->orders()
            ->with('details.product')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Pastikan order milik user yang login
        abort_if($order->user_id !== auth()->id(), 403);

        $order->load(['details.product', 'delivery']);

        return view('orders.detail', compact('order'));
    }

public function cancelOrder(Order $order)
{
    abort_if($order->user_id !== auth()->id(), 403);
    
    if ($order->status !== 'pending') {
        return back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
    }

    \DB::transaction(function () use ($order) {
        // Kembalikan stok
        foreach ($order->details as $detail) {
            \App\Models\Product::where('id', $detail->product_id)
                ->increment('stok', $detail->kuantitas);
        }

        // Hapus delivery jika ada
        $order->delivery()->delete();

        // Update status
        $order->update(['status' => 'dibatalkan']);
    });

    return redirect()->route('orders.index')->with('success', 'Pesanan #' . $order->id . ' berhasil dibatalkan.');
}
}