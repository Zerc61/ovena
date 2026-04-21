@extends('layouts.app')
@section('content')
<div style="max-width:900px;margin:0 auto;padding:28px 20px 40px;">
    <a href="{{ route('orders.index') }}" style="display:inline-flex;align-items:center;gap:4px;font-size:13px;color:var(--cream-muted);text-decoration:none;margin-bottom:20px;opacity:.5;"><i data-lucide="arrow-left" style="width:14px;height:14px;"></i> Pesanan Saya</a>

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:22px;font-weight:600;color:var(--cream);">Pesanan #{{ $order->id }}</h1>
            <span style="font-size:13px;color:var(--cream-muted);opacity:.5;">{{ $order->tanggal_order->format('d F Y, H:i') }}</span>
        </div>
        <div style="display:flex;align-items:center;gap:8px;">
            @if($order->status === 'pending')
            <form method="POST" action="{{ route('orders.cancel', $order) }}" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                @csrf
                <button type="submit" style="padding:9px 18px;background:rgba(153,27,27,0.2);color:#fca5a5;border:1px solid rgba(153,27,27,0.3);border-radius:8px;font-family:'Inter',sans-serif;font-size:12px;font-weight:500;cursor:pointer;transition:all .2s;display:inline-flex;align-items:center;gap:5px;" onmouseover="this.style.background='rgba(153,27,27,0.35)'" onmouseout="this.style.background='rgba(153,27,27,0.2)'">
                    <i data-lucide="x-circle" style="width:14px;height:14px;"></i> Batalkan Pesanan
                </button>
            @endif
            <span class="status-badge status-{{ $order->status }}" style="font-size:12px;padding:5px 14px;">{{ ucfirst($order->status) }}</span>
        </div>
    </div>

    {{-- Pesanan dibatalkan notice --}}
    @if($order->status === 'dibatalkan')
    <div style="background:rgba(153,27,27,0.1);border:1px solid rgba(153,27,27,0.2);border-radius:12px;padding:16px 20px;margin-bottom:20px;display:flex;align-items:center;gap:12px;">
        <i data-lucide="info" style="width:20px;height:20px;color:#fca5a5;flex-shrink:0;"></i>
        <div>
            <div style="font-size:13px;font-weight:600;color:#fca5a5;margin-bottom:2px;">Pesanan Dibatalkan</div>
            <div style="font-size:12px;color:var(--cream-muted);opacity:.5;">Pesanan ini telah dibatalkan oleh kamu. Stok produk sudah dikembalikan.</div>
        </div>
    @endif

    {{-- Tracking Pengiriman --}}
    @if($order->delivery)
    <div style="background:rgba(44,24,16,0.5);border:1px solid rgba(201,169,110,0.06);border-radius:14px;padding:20px;margin-bottom:20px;">
        <h3 style="font-size:15px;font-weight:600;color:var(--cream);margin-bottom:14px;">Tracking Pengiriman</h3>
        <div style="display:flex;gap:24px;flex-wrap:wrap;">
            <div><span style="font-size:11px;color:var(--cream-muted);opacity:.5;">Kurir</span><div style="font-size:14px;color:var(--cream);margin-top:2px;">{{ $order->delivery->nama_kurir }}</div></div>
            @if($order->delivery->no_telp_kurir)
            <div><span style="font-size:11px;color:var(--cream-muted);opacity:.5;">Telepon Kurir</span><div style="font-size:14px;color:var(--cream);margin-top:2px;">{{ $order->delivery->no_telp_kurir }}</div></div>
            @endif
            @if($order->delivery->plat_kendaraan)
            <div><span style="font-size:11px;color:var(--cream-muted);opacity:.5;">Kendaraan</span><div style="font-size:14px;color:var(--cream);margin-top:2px;">{{ $order->delivery->plat_kendaraan }}</div></div>
            @endif
            <div><span style="font-size:11px;color:var(--cream-muted);opacity:.5;">Status</span><div style="font-size:14px;color:var(--gold);margin-top:2px;">{{ ucfirst($order->delivery->status_pengantaran) }}</div></div>
        </div>
        @if($order->delivery->waktu_berangkat)
        <div style="font-size:12px;color:var(--cream-muted);opacity:.4;margin-top:10px;">Berangkat: {{ $order->delivery->waktu_berangkat->format('d M Y, H:i') }}</div>
        @endif
        @if($order->delivery->waktu_sampai)
        <div style="font-size:12px;color:#4ade80;margin-top:2px;">Terkirim: {{ $order->delivery->waktu_sampai->format('d M Y, H:i') }}</div>
        @endif
    </div>
    @endif

    <div style="display:grid;grid-template-columns:1.3fr 1fr;gap:20px;">
        <div style="background:rgba(44,24,16,0.45);border:1px solid rgba(201,169,110,0.06);border-radius:14px;padding:20px;">
            <h3 style="font-size:15px;font-weight:600;color:var(--cream);margin-bottom:14px;">Item Pesanan</h3>
            {{-- Item Pesanan --}}
@foreach($order->details as $d)
<div style="display:flex;gap:12px;padding:10px 0;border-bottom:1px solid rgba(201,169,110,0.04);">
    @php $imgUrl = $d->product->image_url ?: 'https://picsum.photos/seed/od' . $d->id . '/60/60.jpg'; @endphp
    <img src="{{ $imgUrl }}" style="width:50px;height:50px;border-radius:8px;object-fit:cover;flex-shrink:0;">
    <div style="flex:1;">
        <div style="font-size:13px;font-weight:500;color:var(--cream);">{{ $d->product->nama_produk }}</div>
        <div style="font-size:12px;color:var(--cream-muted);opacity:.5;">x{{ $d->kuantitas }} · {{ number_format($d->harga_satuan,0,'.','.') }}/pcs</div>
        @if($d->catatan_khusus)<div style="font-size:11px;color:var(--gold);opacity:.6;margin-top:2px;">Catatan: {{ $d->catatan_khusus }}</div>@endif
    </div>
    <div style="font-size:13px;font-weight:600;color:var(--cream);flex-shrink:0;align-self:center;">{{ number_format($d->harga_satuan * $d->kuantitas,0,'.','.') }}</div>
</div>
@endforeach

        </div>
        <div style="background:rgba(44,24,16,0.45);border:1px solid rgba(201,170,110,0.06);border-radius:14px;padding:20px;align-self:start;">
            <h3 style="font-size:15px;font-weight:600;color:var(--cream);margin-bottom:14px;">Info Pesanan</h3>
            <div style="display:flex;flex-direction:column;gap:10px;font-size:13px;">
                <div><span style="color:var(--cream-muted);opacity:.5;">Penerima</span><div style="color:var(--cream);margin-top:2px;">{{ $order->nama_penerima }}</div></div>
                <div><span style="color:var(--cream-muted);opacity:.5;">Telepon</span><div style="color:var(--cream);margin-top:2px;">{{ $order->no_telp_penerima }}</div></div>
                <div><span style="color:var(--cream-muted);opacity:.5;">Alamat</span><div style="color:var(--cream);margin-top:2px;line-height:1.5;">{{ $order->alamat_pengiriman }}</div></div>
                <div><span style="color:var(--cream-muted);opacity:.5;">Pembayaran</span><div style="color:var(--cream);margin-top:2px;text-transform:capitalize;">{{ $order->metode_pembayaran }}</div></div>
                @if($order->catatan)
                <div><span style="color:var(--cream-muted);opacity:.5;">Catatan</span><div style="color:var(--cream);margin-top:2px;">{{ $order->catatan }}</div></div>
                @endif
                <div style="border-top:1px solid rgba(201,169,110,0.08);padding-top:10px;margin-top:4px;display:flex;justify-content:space-between;">
                    <span style="font-weight:600;color:var(--cream);">Total</span>
                    <span style="font-weight:700;color:var(--gold);font-family:'Playfair Display',serif;font-size:18px;">{{ number_format($order->total_harga,0,'.','.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection