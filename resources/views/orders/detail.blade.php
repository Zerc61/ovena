@extends('layouts.app')

@section('content')
<style>
    /* --- CSS KHUSUS DETAIL PESANAN --- */
    .detail-wrapper {
        max-width: 900px; margin: 0 auto; padding: 28px 20px 60px;
    }
    
    /* Tombol Kembali */
    .btn-back {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 13px; font-weight: 500; color: var(--cream-muted);
        text-decoration: none; margin-bottom: 24px; transition: all 0.3s;
    }
    .btn-back:hover { color: var(--gold); transform: translateX(-4px); }

    /* Header & Badges */
    .order-header {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 16px; margin-bottom: 28px;
    }
    .order-title {
        font-size: 26px; font-weight: 600; color: var(--cream);
        font-family: 'Playfair Display', serif; line-height: 1.2;
    }
    .order-date { font-size: 13px; color: var(--cream-muted); opacity: 0.7; }
    
    .status-badge-lg {
        padding: 6px 16px; border-radius: 20px; font-size: 12px; font-weight: 600;
        text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid transparent;
    }
    .status-pending { background: rgba(201,169,110,0.1); color: var(--gold); border-color: rgba(201,169,110,0.2); }
    .status-dibayar { background: rgba(59,130,246,0.1); color: #60a5fa; border-color: rgba(59,130,246,0.2); }
    .status-diproses { background: rgba(168,85,247,0.1); color: #c084fc; border-color: rgba(168,85,247,0.2); }
    .status-dikirim { background: rgba(37,211,102,0.1); color: #4ade80; border-color: rgba(37,211,102,0.2); }
    .status-selesai { background: rgba(34,197,94,0.1); color: #22c55e; border-color: rgba(34,197,94,0.2); }
    .status-dibatalkan { background: rgba(239,68,68,0.1); color: #f87171; border-color: rgba(239,68,68,0.2); }

    /* Cards */
    .info-card {
        background: linear-gradient(145deg, rgba(44,24,16,0.4) 0%, rgba(26,14,8,0.7) 100%);
        backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(201,169,110,0.1); border-radius: 16px;
        padding: 24px; margin-bottom: 20px; box-shadow: 0 12px 32px rgba(0,0,0,0.15);
    }
    .card-title {
        font-size: 15px; font-weight: 600; color: var(--cream);
        margin-bottom: 16px; display: flex; align-items: center; gap: 8px;
    }
    .card-title::before {
        content: ''; width: 12px; height: 12px; border-radius: 3px;
        background: var(--gold); display: inline-block;
    }

    /* Tracking Section */
    .track-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 16px;
    }
    .track-item { background: rgba(26,14,8,0.4); padding: 12px 16px; border-radius: 10px; border: 1px solid rgba(201,169,110,0.05); }
    .track-label { font-size: 11px; color: var(--cream-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
    .track-value { font-size: 14px; font-weight: 500; color: var(--cream); }

    /* Items List */
    .order-item-row {
        display: flex; gap: 16px; padding: 16px 0;
        border-bottom: 1px dashed rgba(201,169,110,0.15);
    }
    .order-item-row:last-child { border-bottom: none; padding-bottom: 0; }
    .item-img {
        width: 64px; height: 64px; border-radius: 12px; object-fit: cover;
        border: 1px solid rgba(201,169,110,0.1); background: rgba(26,14,8,0.8);
    }

    /* Summary List */
    .summary-row {
        display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 12px;
    }
    .summary-label { color: var(--cream-muted); }
    .summary-val { color: var(--cream); font-weight: 500; text-align: right; max-width: 65%; line-height: 1.5; }

    /* Buttons */
    .btn-cancel {
        padding: 10px 16px; background: transparent; color: #fca5a5;
        border: 1px solid rgba(239,68,68,0.3); border-radius: 10px; font-size: 12px; font-weight: 500;
        cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-cancel:hover { background: rgba(239,68,68,0.1); border-color: #ef4444; color: #ef4444; }

    /* Layout Grid */
    .main-grid { display: grid; grid-template-columns: 1.4fr 1fr; gap: 24px; }
    @media (max-width: 768px) { .main-grid { grid-template-columns: 1fr; } }
</style>

<div class="detail-wrapper">
    <a href="{{ route('orders.index') }}" class="btn-back">
        <i data-lucide="arrow-left" style="width:16px; height:16px;"></i> Kembali ke Riwayat Pesanan
    </a>

    <div class="order-header">
        <div>
            <h1 class="order-title">Pesanan #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h1>
            <div class="order-date">{{ $order->tanggal_order->format('d F Y, H:i') }} WIB</div>
        </div>
        <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
            @if($order->status === 'pending')
                <form method="POST" action="{{ route('orders.cancel', $order) }}" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat diurungkan.')">
                    @csrf
                    <button type="submit" class="btn-cancel">
                        <i data-lucide="x-octagon" style="width:14px; height:14px;"></i> Batalkan Pesanan
                    </button>
                </form>
            @endif
            <span class="status-badge-lg status-{{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</span>
        </div>
    </div>

    {{-- Pesanan Dibatalkan Notice --}}
    @if($order->status === 'dibatalkan')
    <div style="background:linear-gradient(to right, rgba(239,68,68,0.1), transparent); border-left:3px solid #ef4444; border-radius:8px; padding:16px 20px; margin-bottom:24px; display:flex; align-items:center; gap:16px;">
        <div style="background:rgba(239,68,68,0.15); padding:8px; border-radius:50%;">
            <i data-lucide="shield-alert" style="width:24px; height:24px; color:#fca5a5;"></i>
        </div>
        <div>
            <div style="font-size:14px; font-weight:600; color:#fca5a5; margin-bottom:4px;">Pesanan Telah Dibatalkan</div>
            <div style="font-size:13px; color:var(--cream-muted); opacity:0.8;">Transaksi dibatalkan dan stok produk telah dikembalikan ke sistem.</div>
        </div>
    </div>
    @endif

    {{-- Tracking Pengiriman (Muncul jika ada data delivery) --}}
    @if($order->delivery)
    <div class="info-card">
        <h3 class="card-title">Informasi Pengiriman</h3>
        <div class="track-grid">
            <div class="track-item">
                <div class="track-label">Kurir</div>
                <div class="track-value">{{ $order->delivery->nama_kurir }}</div>
            </div>
            
            @if($order->delivery->no_telp_kurir)
            <div class="track-item">
                <div class="track-label">Telepon Kurir</div>
                <div class="track-value">{{ $order->delivery->no_telp_kurir }}</div>
            </div>
            @endif
            
            @if($order->delivery->plat_kendaraan)
            <div class="track-item">
                <div class="track-label">Kendaraan</div>
                <div class="track-value">{{ $order->delivery->plat_kendaraan }}</div>
            </div>
            @endif
            
            <div class="track-item" style="background:rgba(201,169,110,0.05); border-color:rgba(201,169,110,0.2);">
                <div class="track-label" style="color:var(--gold);">Status Antar</div>
                <div class="track-value" style="color:var(--gold-light);">{{ ucfirst($order->delivery->status_pengantaran) }}</div>
            </div>
        </div>

        <div style="display:flex; gap:24px; margin-top:16px; padding-top:16px; border-top:1px dashed rgba(201,169,110,0.1);">
            @if($order->delivery->waktu_berangkat)
            <div>
                <div style="font-size:11px; color:var(--cream-muted);">Waktu Berangkat</div>
                <div style="font-size:13px; color:var(--cream);">{{ $order->delivery->waktu_berangkat->format('d M Y, H:i') }}</div>
            </div>
            @endif
            
            @if($order->delivery->waktu_sampai)
            <div>
                <div style="font-size:11px; color:var(--cream-muted);">Waktu Sampai</div>
                <div style="font-size:13px; color:#4ade80; font-weight:500;"><i data-lucide="check-circle-2" style="width:12px;height:12px;display:inline-block;vertical-align:middle;"></i> {{ $order->delivery->waktu_sampai->format('d M Y, H:i') }}</div>
            </div>
            @endif
        </div>
    </div>
    @endif

    <div class="main-grid">
        <div class="info-card">
            <h3 class="card-title">Item Pesanan</h3>
            <div style="margin-top:20px;">
                @foreach($order->details as $d)
                <div class="order-item-row">
                    @php $imgUrl = $d->product->image_url ?: 'https://picsum.photos/seed/od' . $d->id . '/100/100.jpg'; @endphp
                    <img src="{{ $imgUrl }}" class="item-img" alt="{{ $d->product->nama_produk }}">
                    
                    <div style="flex:1; display:flex; flex-direction:column; justify-content:center;">
                        <div style="font-size:15px; font-weight:600; color:var(--cream); margin-bottom:4px; font-family:'Playfair Display', serif;">{{ $d->product->nama_produk }}</div>
                        <div style="font-size:12px; color:var(--cream-muted);">{{ $d->kuantitas }} x Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</div>
                        
                        @if($d->catatan_khusus)
                        <div style="font-size:11px; color:var(--gold); font-style:italic; margin-top:6px; background:rgba(201,169,110,0.05); padding:4px 8px; border-radius:6px; display:inline-block; align-self:flex-start;">
                            <i data-lucide="pen-line" style="width:10px; height:10px; display:inline-block; vertical-align:middle;"></i> {{ $d->catatan_khusus }}
                        </div>
                        @endif
                    </div>
                    
                    <div style="font-size:14px; font-weight:700; color:var(--gold); align-self:center;">
                        Rp {{ number_format($d->harga_satuan * $d->kuantitas, 0, ',', '.') }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="info-card" style="align-self:start;">
            <h3 class="card-title">Rincian Pengiriman</h3>
            
            <div style="margin-top:20px;">
                <div class="summary-row">
                    <span class="summary-label">Nama Penerima</span>
                    <span class="summary-val">{{ $order->nama_penerima }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">No. WhatsApp</span>
                    <span class="summary-val">{{ $order->no_telp_penerima }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Alamat Lengkap</span>
                    <span class="summary-val">{{ $order->alamat_pengiriman }}</span>
                </div>
                
                @if($order->catatan)
                <div class="summary-row" style="background:rgba(26,14,8,0.4); padding:10px; border-radius:8px; border:1px solid rgba(201,169,110,0.05); margin-top:16px;">
                    <span class="summary-label">Catatan Pesanan:</span>
                    <span class="summary-val" style="font-style:italic; color:var(--gold-light);">"{{ $order->catatan }}"</span>
                </div>
                @endif
            </div>

            <div style="height:1px; background:rgba(201,169,110,0.1); margin:20px 0;"></div>
            
            <h3 class="card-title" style="margin-bottom:16px;">Pembayaran</h3>
            <div class="summary-row">
                <span class="summary-label">Metode Pembayaran</span>
                <span class="summary-val" style="text-transform:uppercase; font-weight:700; color:var(--gold);">
                    @if($order->metode_pembayaran === 'transfer')
                        Virtual Account
                    @elseif($order->metode_pembayaran === 'qris')
                        QRIS
                    @elseif($order->metode_pembayaran === 'ewallet')
                        E-Wallet
                    @else
                        {{ $order->metode_pembayaran }}
                    @endif
                </span>
            </div>
            
            <div style="margin-top:24px; padding-top:16px; border-top:1px dashed rgba(201,169,110,0.3); display:flex; justify-content:space-between; align-items:flex-end;">
                <div>
                    <div style="font-size:11px; color:var(--cream-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">Total Belanja</div>
                    <div style="font-size:10px; color:rgba(200,185,168,0.5);">Termasuk pajak & biaya</div>
                </div>
                <div style="font-size:24px; font-weight:700; color:var(--gold); font-family:'Playfair Display', serif;">
                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                </div>
            </div>
            
            @if($order->status === 'pending')
                <a href="{{ route('payment.index', $order->id) }}" style="display:block; width:100%; text-align:center; background:var(--gold); color:var(--brown-deep); text-decoration:none; padding:12px; border-radius:10px; font-size:14px; font-weight:600; margin-top:20px; transition:all 0.3s;" onmouseover="this.style.background='var(--gold-light)'" onmouseout="this.style.background='var(--gold)'">
                    Selesaikan Pembayaran <i data-lucide="arrow-right" style="width:16px; height:16px; display:inline-block; vertical-align:middle;"></i>
                </a>
            @endif
        </div>
    </div>
</div>
@endsection