@extends('layouts.app')
@section('content')
<div style="max-width:900px;margin:0 auto;padding:28px 20px 40px;">
    <h1 style="font-size:24px;font-weight:600;color:var(--cream);margin-bottom:24px;">Pesanan Saya</h1>
    @if($orders->isEmpty())
    <div style="text-align:center;padding:60px 20px;color:var(--cream-muted);opacity:.4;">
        <i data-lucide="package" style="width:48px;height:48px;margin:0 auto 12px;display:block;"></i>
        <p>Belum ada pesanan.</p>
        <a href="/" class="btn-outline" style="margin-top:16px;display:inline-flex;">Belanja Sekarang</a>
    </div>
    @else
    <div style="display:flex;flex-direction:column;gap:10px;">
        @foreach($orders as $order)
        <a href="{{ route('orders.show', $order) }}" style="display:flex;align-items:center;justify-content:space-between;padding:16px 18px;background:rgba(44,24,16,0.45);border:1px solid rgba(201,169,110,0.06);border-radius:12px;text-decoration:none;color:inherit;transition:all .2s;" onmouseover="this.style.borderColor='rgba(201,169,110,0.15)'" onmouseout="this.style.borderColor='rgba(201,169,110,0.06)'">
            <div>
                <div style="font-size:12px;color:var(--cream-muted);opacity:.5;">{{ $order->tanggal_order->format('d M Y, H:i') }}</div>
                <div style="font-size:14px;font-weight:500;color:var(--cream);margin-top:2px;">{{ $order->details->count() }} item</div>
            </div>
            <div style="text-align:right;">
                <div style="font-size:14px;font-weight:700;color:var(--gold);">{{ number_format($order->total_harga,0,'.','.') }}</div>
                <span class="status-badge status-{{ $order->status }}" style="display:inline-block;margin-top:4px;">{{ ucfirst($order->status) }}</span>
            </div>
        </a>
        @endforeach
    </div>
    <div style="display:flex;justify-content:center;margin-top:20px;">{{ $orders->links() }}</div>
    @endif
</div>
@endsection