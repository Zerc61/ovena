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

@if($pendingOrders > 0)
<div class="glass-card fade-up" style="margin-bottom:20px;">
    <h3 style="font-size:14px;font-weight:600;color:var(--gold);margin-bottom:12px;">⚠ Pesanan Menunggu Proses</h3>
    <a href="{{ route('admin.orders.index') }}?status=pending" class="btn-gold btn-sm" style="text-decoration:none;">Lihat Semua</a>
</div>
@endif
@endsection