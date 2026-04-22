@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="fade-up" style="margin-bottom:24px;">
    <h1 style="font-size:22px;font-weight:600;color:var(--cream);">Dashboard</h1>
</div>

<div class="stat-grid" style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:28px;">
    <div class="stat-card fade-up">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
            <span style="font-size:11px;color:var(--cream-muted);text-transform:uppercase;letter-spacing:.5px;">Total Penjualan</span>
            <div style="width:36px;height:36px;border-radius:10px;background:rgba(34,197,94,0.1);display:flex;align-items:center;justify-content:center;">
                <i data-lucide="trending-up" style="width:18px;height:18px;color:#22c55e;"></i>
            </div>
        </div>
        <div style="font-size:22px;font-weight:700;color:var(--gold);font-family:'Playfair Display',serif;">{{ number_format($totalPenjualan,0,'.','.') }}</div>
        <div style="font-size:11px;color:var(--cream-muted);opacity:.4;margin-top:4px;">Pesanan selesai</div>
    </div>
    <div class="stat-card fade-up">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
            <span style="font-size:11px;color:var(--cream-muted);text-transform:uppercase;letter-spacing:.5px;">Total Pesanan</span>
            <div style="width:36px;height:36px;border-radius:10px;background:rgba(201,169,110,0.1);display:flex;align-items:center;justify-content:center;">
                <i data-lucide="clipboard-list" style="width:18px;height:18px;color:var(--gold);"></i>
            </div>
        </div>
        <div style="font-size:22px;font-weight:700;color:var(--cream);font-family:'Playfair Display',serif;">{{ $totalPesanan }}</div>
        <div style="font-size:11px;color:var(--cream-muted);opacity:.4;margin-top:4px;">Semua status</div>
    </div>
    <div class="stat-card fade-up">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
            <span style="font-size:11px;color:var(--cream-muted);text-transform:uppercase;letter-spacing:.5px;">Total Produk</span>
            <div style="width:36px;height:36px;border-radius:10px;background:rgba(168,85,247,0.1);display:flex;align-items:center;justify-content:center;">
                <i data-lucide="cake-slice" style="width:18px;height:18px;color:#c084fc;"></i>
            </div>
        </div>
        <div style="font-size:22px;font-weight:700;color:var(--cream);font-family:'Playfair Display',serif;">{{ $totalProduk }}</div>
        <div style="font-size:11px;color:var(--cream-muted);opacity:.4;margin-top:4px;">Aktif</div>
    </div>
    <div class="stat-card fade-up">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
            <span style="font-size:11px;color:var(--cream-muted);text-transform:uppercase;letter-spacing:.5px;">Menunggu</span>
            <div style="width:36px;height:36px;border-radius:10px;background:rgba(201,169,110,0.1);display:flex;align-items:center;justify-content:center;">
                <i data-lucide="clock" style="width:18px;height:18px;color:var(--gold);"></i>
            </div>
        </div>
        <div style="font-size:22px;font-weight:700;color:{{ $pendingOrders > 0 ? 'var(--gold)' : 'var(--cream-muted)' }};font-family:'Playfair Display',serif;">{{ $pendingOrders }}</div>
        <div style="font-size:11px;color:var(--cream-muted);opacity:.4;margin-top:4px;">Pending</div>
    </div>
</div>

{{-- Alert Pesanan Menunggu --}}
@if($pendingOrders > 0)
<div class="glass-card fade-up" style="margin-bottom:28px; border-left: 4px solid var(--gold);">
    <div style="display:flex; align-items:center; justify-content:space-between;">
        <div>
            <h3 style="font-size:14px;font-weight:600;color:var(--gold);margin-bottom:4px;display:flex;align-items:center;gap:6px;">
                <i data-lucide="alert-circle" style="width:16px;height:16px;"></i> Pesanan Menunggu Proses
            </h3>
            <p style="font-size:12px;color:var(--cream-muted);margin:0;opacity:0.7;">Ada {{ $pendingOrders }} pesanan pelanggan yang perlu segera dikonfirmasi.</p>
        </div>
        <a href="{{ route('admin.orders.index') }}?status=pending" class="btn-gold btn-sm" style="text-decoration:none;">Lihat Pesanan</a>
    </div>
</div>
@endif

{{-- Menu Akses Cepat Fitur Baru --}}
<div class="fade-up" style="margin-bottom:14px;">
    <h2 style="font-size:16px;font-weight:600;color:var(--cream);">Akses Cepat Pemasaran</h2>
</div>
<div style="display:grid;grid-template-columns:repeat(2,1fr);gap:16px;margin-bottom:28px;">
    {{-- Card Banner --}}
    <a href="{{ route('admin.banners.index') }}" class="glass-card fade-up" style="display:flex;align-items:center;gap:16px;text-decoration:none;transition:all 0.3s;cursor:pointer;" onmouseover="this.style.borderColor='var(--gold)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.borderColor='rgba(201,169,110,0.06)'; this.style.transform='none';">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(201,169,110,0.1);border:1px solid rgba(201,169,110,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i data-lucide="image" style="width:22px;height:22px;color:var(--gold);"></i>
        </div>
        <div>
            <h3 style="font-size:14px;font-weight:600;color:var(--cream);margin-bottom:4px;">Kelola Banner Promo</h3>
            <p style="font-size:11px;color:var(--cream-muted);margin:0;opacity:0.6;line-height:1.4;">Atur gambar slide dan penawaran spesial di halaman utama toko.</p>
        </div>
        <i data-lucide="chevron-right" style="width:16px;height:16px;color:var(--cream-muted);opacity:0.4;margin-left:auto;"></i>
    </a>

    {{-- Card Voucher --}}
    <a href="{{ route('admin.vouchers.index') }}" class="glass-card fade-up" style="display:flex;align-items:center;gap:16px;text-decoration:none;transition:all 0.3s;cursor:pointer;" onmouseover="this.style.borderColor='var(--gold)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.borderColor='rgba(201,169,110,0.06)'; this.style.transform='none';">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(201,169,110,0.1);border:1px solid rgba(201,169,110,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i data-lucide="ticket" style="width:22px;height:22px;color:var(--gold);"></i>
        </div>
        <div>
            <h3 style="font-size:14px;font-weight:600;color:var(--cream);margin-bottom:4px;">Kelola Voucher Diskon</h3>
            <p style="font-size:11px;color:var(--cream-muted);margin:0;opacity:0.6;line-height:1.4;">Buat dan atur kode potongan harga (persen/nominal) untuk pelanggan.</p>
        </div>
        <i data-lucide="chevron-right" style="width:16px;height:16px;color:var(--cream-muted);opacity:0.4;margin-left:auto;"></i>
    </a>
</div>


@endsection