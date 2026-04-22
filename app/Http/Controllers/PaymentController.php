<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function show(Order $order)
    {
        // Keamanan: Pastikan order ini milik user yang sedang login
        abort_if($order->user_id !== auth()->id(), 403);
        
        // Jika statusnya bukan pending (sudah dibayar/batal), langsung lempar ke detail order
        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order->id)
                ->with('info', 'Status pesanan ini sudah diperbarui.');
        }

        // Tampilkan halaman payment.blade.php yang kita buat sebelumnya
        return view('payment.show', compact('order')); 
    }

    public function simulate(Request $request, $id)
    {
        $order = \App\Models\Order::findOrFail($id);

        // Jika metode COD, status langsung menjadi 'diproses'
        if ($order->metode_pembayaran === 'cod') {
            $order->update(['status' => 'diproses']);
            $pesan = 'Pesanan COD berhasil dikonfirmasi dan sedang diproses!';
        } else {
            // Jika metode lain (Transfer, E-Wallet, QRIS), status menjadi 'dibayar'
            $order->update(['status' => 'dibayar']);
            $pesan = 'Pembayaran berhasil disimulasikan!';
        }

        // Sesuaikan route redirect di bawah ini dengan halaman riwayat pesanan/home kamu
               return redirect()->route('orders.show', $order->id)
            ->with('success', 'Pembayaran berhasil dikonfirmasi (Simulasi)!', $pesan);
    }
}