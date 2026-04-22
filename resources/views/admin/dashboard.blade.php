@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="fade-up" style="margin-bottom:24px;">
    <h1 style="font-size:22px;font-weight:600;color:var(--cream);">Dashboard Overview</h1>
    <p style="font-size:13px;color:var(--cream-muted);margin-top:4px;">Pantau performa toko dan ulasan pelanggan hari ini.</p>
</div>

{{-- 4 Kotak Statistik Utama --}}
<div class="stat-grid" style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:28px;">
    <div class="stat-card fade-up">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
            <span style="font-size:11px;color:var(--cream-muted);text-transform:uppercase;letter-spacing:.5px;">Pendapatan</span>
            <div style="width:36px;height:36px;border-radius:10px;background:rgba(34,197,94,0.1);display:flex;align-items:center;justify-content:center;">
                <i data-lucide="trending-up" style="width:18px;height:18px;color:#22c55e;"></i>
            </div>
        </div>
        <div style="font-size:22px;font-weight:700;color:var(--gold);font-family:'Playfair Display',serif;">{{ number_format($totalPenjualan,0,'.','.') }}</div>
        <div style="font-size:11px;color:var(--cream-muted);opacity:.4;margin-top:4px;">Dari pesanan selesai</div>
    </div>
    <div class="stat-card fade-up">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
            <span style="font-size:11px;color:var(--cream-muted);text-transform:uppercase;letter-spacing:.5px;">Total Pesanan</span>
            <div style="width:36px;height:36px;border-radius:10px;background:rgba(201,169,110,0.1);display:flex;align-items:center;justify-content:center;">
                <i data-lucide="shopping-bag" style="width:18px;height:18px;color:var(--gold);"></i>
            </div>
        </div>
        <div style="font-size:22px;font-weight:700;color:var(--cream);font-family:'Playfair Display',serif;">{{ $totalPesanan }}</div>
        <div style="font-size:11px;color:var(--cream-muted);opacity:.4;margin-top:4px;">Keseluruhan transaksi</div>
    </div>
    <div class="stat-card fade-up">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
            <span style="font-size:11px;color:var(--cream-muted);text-transform:uppercase;letter-spacing:.5px;">Katalog Produk</span>
            <div style="width:36px;height:36px;border-radius:10px;background:rgba(168,85,247,0.1);display:flex;align-items:center;justify-content:center;">
                <i data-lucide="cake-slice" style="width:18px;height:18px;color:#c084fc;"></i>
            </div>
        </div>
        <div style="font-size:22px;font-weight:700;color:var(--cream);font-family:'Playfair Display',serif;">{{ $totalProduk }}</div>
        <div style="font-size:11px;color:var(--cream-muted);opacity:.4;margin-top:4px;">Produk aktif</div>
    </div>
    <div class="stat-card fade-up">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
            <span style="font-size:11px;color:var(--cream-muted);text-transform:uppercase;letter-spacing:.5px;">Menunggu Proses</span>
            <div style="width:36px;height:36px;border-radius:10px;background:rgba(248,113,113,0.1);display:flex;align-items:center;justify-content:center;">
                <i data-lucide="bell-ring" style="width:18px;height:18px;color:#f87171;"></i>
            </div>
        </div>
        <div style="font-size:22px;font-weight:700;color:{{ $pendingOrders > 0 ? '#f87171' : 'var(--cream-muted)' }};font-family:'Playfair Display',serif;">{{ $pendingOrders }}</div>
        <div style="font-size:11px;color:var(--cream-muted);opacity:.4;margin-top:4px;">Butuh konfirmasi</div>
    </div>
</div>

{{-- Alert Pesanan Menunggu --}}
@if($pendingOrders > 0)
<div class="glass-card fade-up" style="margin-bottom:28px; border-left: 4px solid #f87171; background:rgba(248,113,113,0.05);">
    <div style="display:flex; align-items:center; justify-content:space-between;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:36px;height:36px;background:rgba(248,113,113,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#f87171;"><i data-lucide="alert-circle" style="width:18px;height:18px;"></i></div>
            <div>
                <h3 style="font-size:14px;font-weight:600;color:#fca5a5;margin-bottom:2px;">Ada Pesanan Baru!</h3>
                <p style="font-size:12px;color:var(--cream-muted);margin:0;">Terdapat {{ $pendingOrders }} pesanan yang menunggu untuk diproses.</p>
            </div>
        </div>
        <a href="{{ route('admin.orders.index') }}?status=pending" class="btn-gold btn-sm" style="text-decoration:none;">Cek Pesanan</a>
    </div>
</div>
@endif

{{-- Grid Utama (Kiri 2 Bagian, Kanan 1 Bagian) --}}
<div style="display:grid;grid-template-columns:1.8fr 1fr;gap:24px;margin-bottom:40px;">
    
    {{-- KOLOM KIRI --}}
    <div style="display:flex;flex-direction:column;gap:24px;">
        
        {{-- Akses Cepat --}}
        <div>
            <h2 style="font-size:15px;font-weight:600;color:var(--cream);margin-bottom:12px;display:flex;align-items:center;gap:6px;"><i data-lucide="zap" style="width:16px;height:16px;color:var(--gold);"></i> Akses Pemasaran</h2>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <a href="{{ route('admin.banners.index') }}" class="glass-card" style="padding:16px;display:flex;align-items:center;gap:14px;text-decoration:none;transition:all 0.3s;cursor:pointer;" onmouseover="this.style.borderColor='var(--gold)';" onmouseout="this.style.borderColor='rgba(201,169,110,0.06)';">
                    <div style="width:40px;height:40px;border-radius:10px;background:rgba(201,169,110,0.1);display:flex;align-items:center;justify-content:center;"><i data-lucide="image" style="width:20px;height:20px;color:var(--gold);"></i></div>
                    <div>
                        <h3 style="font-size:13px;font-weight:600;color:var(--cream);margin-bottom:2px;">Banner Promo</h3>
                        <p style="font-size:11px;color:var(--cream-muted);margin:0;opacity:0.6;">Atur slide beranda</p>
                    </div>
                </a>
                <a href="{{ route('admin.vouchers.index') }}" class="glass-card" style="padding:16px;display:flex;align-items:center;gap:14px;text-decoration:none;transition:all 0.3s;cursor:pointer;" onmouseover="this.style.borderColor='var(--gold)';" onmouseout="this.style.borderColor='rgba(201,169,110,0.06)';">
                    <div style="width:40px;height:40px;border-radius:10px;background:rgba(201,169,110,0.1);display:flex;align-items:center;justify-content:center;"><i data-lucide="ticket" style="width:20px;height:20px;color:var(--gold);"></i></div>
                    <div>
                        <h3 style="font-size:13px;font-weight:600;color:var(--cream);margin-bottom:2px;">Voucher Diskon</h3>
                        <p style="font-size:11px;color:var(--cream-muted);margin:0;opacity:0.6;">Buat kode kupon</p>
                    </div>
                </a>
            </div>
        </div>

        {{-- Ulasan Terbaru --}}
        <div class="glass-card" style="padding:20px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <h2 style="font-size:15px;font-weight:600;color:var(--cream);display:flex;align-items:center;gap:6px;"><i data-lucide="message-square-heart" style="width:16px;height:16px;color:var(--gold);"></i> Ulasan Terbaru</h2>
                <span style="font-size:11px;color:var(--cream-muted);background:rgba(201,169,110,0.1);padding:4px 8px;border-radius:6px;">{{ $recentReviews->count() }} Terakhir</span>
            </div>
            
            @if($recentReviews->isEmpty())
                <div style="text-align:center;padding:20px;color:var(--cream-muted);opacity:.5;font-size:12px;">Belum ada ulasan produk.</div>
            @else
                <div style="display:flex;flex-direction:column;gap:12px;">
                    @foreach($recentReviews as $review)
                    <div style="background:rgba(26,14,8,0.4);border:1px solid rgba(201,169,110,0.05);border-radius:10px;padding:12px;">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:6px;">
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="width:28px;height:28px;border-radius:50%;background:var(--brown-rich);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:bold;color:var(--gold);">{{ substr($review->user->nama,0,1) }}</div>
                                <div>
                                    <div style="font-size:12px;font-weight:600;color:var(--cream);">{{ $review->user->nama }}</div>
                                    <div style="font-size:10px;color:var(--cream-muted);opacity:0.7;">Untuk: <span style="color:var(--gold);">{{ $review->product->nama_produk }}</span></div>
                                </div>
                            </div>
                            <div style="display:flex;gap:2px;">
                                @for($i=1; $i<=5; $i++)
                                    <i data-lucide="star" style="width:10px;height:10px; {{ $i <= $review->rating ? 'fill:var(--gold);color:var(--gold);' : 'color:rgba(201,169,110,0.2);' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <p style="font-size:12px;color:var(--cream-muted);line-height:1.5;margin:0;font-style:italic;">"{{ \Illuminate\Support\Str::limit($review->komentar, 80) }}"</p>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- KOLOM KANAN: BEST SELLER --}}
    @if($bestSeller)
    <div style="display:flex;flex-direction:column;">
        <h2 style="font-size:15px;font-weight:600;color:var(--cream);margin-bottom:12px;display:flex;align-items:center;gap:6px;"><i data-lucide="crown" style="width:16px;height:16px;color:var(--gold);"></i> Bintang Utama</h2>
        
        <div style="position:relative;background:var(--brown-rich);border:1px solid rgba(201,169,110,0.1);border-radius:16px;overflow:hidden;flex:1;display:flex;flex-direction:column;">
            {{-- Badge --}}
            <div style="position:absolute;top:16px;left:16px;background:var(--gold);color:var(--brown-deep);padding:6px 12px;border-radius:20px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;z-index:2;display:flex;align-items:center;gap:4px;box-shadow:0 4px 10px rgba(0,0,0,0.3);">
                <i data-lucide="flame" style="width:12px;height:12px;"></i> #1 Best Seller
            </div>
            
           {{-- Gambar --}}
            <div style="height:160px;position:relative;background:rgba(26,14,8,0.8);display:flex;align-items:center;justify-content:center;padding:20px;">
                <img src="{{ $bestSeller->url_gambar ? asset('storage/'.$bestSeller->url_gambar) : 'https://picsum.photos/seed/'.$bestSeller->id.'/400/300' }}" style="max-width:80%;max-height:100%;object-fit:contain;opacity:0.9;filter:drop-shadow(0 10px 20px rgba(0,0,0,0.4));">
                <div style="position:absolute;bottom:0;left:0;width:100%;height:80px;background:linear-gradient(to top, var(--brown-rich), transparent);pointer-events:none;"></div>
            </div>
            
            {{-- Info --}}
            <div style="padding:20px;position:relative;z-index:2;margin-top:-30px;flex:1;display:flex;flex-direction:column;justify-content:space-between;">
                <div>
                    <h3 style="font-size:18px;font-weight:600;color:var(--cream);margin-bottom:6px;line-height:1.3;">{{ $bestSeller->nama_produk }}</h3>
                    <div style="font-size:16px;font-weight:700;color:var(--gold);font-family:'Playfair Display',serif;margin-bottom:16px;">{{ number_format($bestSeller->harga,0,'.','.') }}</div>
                </div>
                
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;border-top:1px solid rgba(201,169,110,0.1);padding-top:16px;">
                    <div>
                        <div style="font-size:10px;color:var(--cream-muted);text-transform:uppercase;margin-bottom:2px;">Terjual</div>
                        <div style="font-size:15px;font-weight:600;color:var(--cream);">{{ $bestSellerSold }} <span style="font-size:11px;font-weight:normal;color:var(--cream-muted);">pcs</span></div>
                    </div>
                    <div>
                        <div style="font-size:10px;color:var(--cream-muted);text-transform:uppercase;margin-bottom:2px;">Sisa Stok</div>
                        <div style="font-size:15px;font-weight:600;color:{{ $bestSeller->stok > 5 ? 'var(--cream)' : '#f87171' }};">{{ $bestSeller->stok }} <span style="font-size:11px;font-weight:normal;color:var(--cream-muted);">pcs</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection