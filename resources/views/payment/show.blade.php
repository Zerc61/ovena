@extends('layouts.app')
@section('content')
<div style="max-width:500px;margin:0 auto;padding:40px 20px;">
    <div style="text-align:center;margin-bottom:32px;">
        <h1 style="font-size:24px;font-weight:600;color:var(--cream);margin-bottom:8px;">Selesaikan Pembayaran</h1>
        <p style="font-size:14px;color:var(--cream-muted);opacity:.7;">Order ID: #{{ $order->id }}</p>
    </div>

    <div style="background:rgba(44,24,16,0.5);border:1px solid rgba(201,169,110,0.06);border-radius:14px;padding:32px;text-align:center;">
        
        {{-- TAMPILAN JIKA MEMILIH QRIS --}}
        @if($order->metode_pembayaran === 'qris')
            <h3 style="font-size:16px;font-weight:600;color:var(--cream);margin-bottom:20px;">Scan QR Code</h3>
            
            {{-- Dummy QR Code (Nanti diganti dengan URL gambar dari API) --}}
            <div style="background:#fff;padding:16px;border-radius:12px;display:inline-block;margin-bottom:20px;">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=DUMMY-PAYMENT-{{ $order->id }}" alt="QRIS" style="width:200px;height:200px;">
            </div>
            
            <p style="font-size:13px;color:var(--cream-muted);line-height:1.6;margin-bottom:0;">
                Buka aplikasi M-Banking atau E-Wallet yang mendukung QRIS, lalu scan kode di atas untuk membayar.
            </p>

        {{-- TAMPILAN JIKA MEMILIH TRANSFER BANK --}}
        @elseif($order->metode_pembayaran === 'transfer')
            <h3 style="font-size:16px;font-weight:600;color:var(--cream);margin-bottom:20px;">Transfer Bank (Virtual Account)</h3>
            
            <div style="background:rgba(0,0,0,0.2);border:1px dashed rgba(201,169,110,0.3);border-radius:12px;padding:20px;margin-bottom:20px;">
                <div style="font-size:12px;color:var(--cream-muted);margin-bottom:8px;">Bank BCA (Contoh)</div>
                <div style="font-size:22px;font-weight:700;color:var(--gold);letter-spacing:2px;">1234 5678 9012</div>
            </div>
            
            <p style="font-size:13px;color:var(--cream-muted);line-height:1.6;margin-bottom:0;">
                Salin nomor rekening di atas dan lakukan transfer sesuai dengan nominal hingga tiga digit terakhir.
            </p>

        {{-- TAMPILAN JIKA MEMILIH E-WALLET --}}
        @elseif($order->metode_pembayaran === 'ewallet')
            <h3 style="font-size:16px;font-weight:600;color:var(--cream);margin-bottom:20px;">Pembayaran E-Wallet</h3>
            <p style="font-size:13px;color:var(--cream-muted);line-height:1.6;margin-bottom:20px;">
                Klik tombol di bawah ini untuk membuka aplikasi E-Wallet (Gopay/OVO/ShopeePay) kamu.
            </p>
            {{-- Tombol dummy untuk buka e-wallet --}}
            <button style="background:#00aadd;color:#fff;border:none;border-radius:8px;padding:12px 24px;font-weight:600;cursor:pointer;">
                Buka Aplikasi E-Wallet
            </button>
            
        {{-- TAMPILAN JIKA MEMILIH COD --}}
        @elseif($order->metode_pembayaran === 'cod')
            <h3 style="font-size:16px;font-weight:600;color:var(--cream);margin-bottom:20px;">Bayar di Tempat (COD)</h3>
            <i data-lucide="truck" style="width:48px;height:48px;color:var(--gold);margin-bottom:16px;opacity:0.8;"></i>
            <p style="font-size:13px;color:var(--cream-muted);line-height:1.6;margin-bottom:0;">
                Siapkan uang tunai pas untuk diberikan kepada kurir saat pesanan sampai di tujuan.
            </p>
        @endif

        <div style="border-top:1px solid rgba(201,169,110,0.08);margin-top:24px;padding-top:24px;">
            <div style="font-size:13px;color:var(--cream-muted);margin-bottom:8px;">Total Pembayaran</div>
            <div style="font-size:28px;font-weight:700;color:var(--gold);font-family:'Playfair Display',serif;">
                Rp {{ number_format($order->total_harga, 0, '.', '.') }}
            </div>
        </div>

        {{-- TOMBOL SIMULASI (Hanya untuk testing sebelum API terpasang) --}}
        <form method="POST" action="{{ route('payment.simulate', $order->id) }}" style="margin-top:24px;">
            @csrf
            <button type="submit" class="btn-gold" style="width:100%;justify-content:center;padding:14px;font-size:14px;">
                Simulasikan Sukses Bayar
            </button>
        </form>

    </div>
</div>
@endsection