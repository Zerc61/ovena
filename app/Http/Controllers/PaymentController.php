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

    public function simulate(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        // Berdasarkan migration-mu, status yang tersedia: 
        // ['pending', 'dibayar', 'diproses', 'dikirim', 'selesai', 'dibatalkan']
        
        // Kita ubah statusnya menjadi 'dibayar' atau 'diproses'
        $order->update([
            'status' => 'dibayar' 
        ]);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Pembayaran berhasil dikonfirmasi (Simulasi)!');
    }
}