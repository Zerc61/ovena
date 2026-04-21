@extends('layouts.app')
@section('content')
<div style="max-width:900px;margin:0 auto;padding:28px 20px 40px;">
    <a href="/" style="display:inline-flex;align-items:center;gap:4px;font-size:13px;color:var(--cream-muted);text-decoration:none;margin-bottom:24px;opacity:.5;"><i data-lucide="arrow-left" style="width:14px;height:14px;"></i> Kembali</a>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:36px;" class="fade-up">
        <div style="border-radius:16px;overflow:hidden;aspect-ratio:1;background:rgba(26,14,8,0.8);">
            <img src="{{ $product->image_url ?: 'https://picsum.photos/seed/detail'.$product->id.'/600/600.jpg' }}" alt="{{ $product->nama_produk }}" style="width:100%;height:100%;object-fit:cover;">
        </div>
        <div>
            @if($product->category)
            <span style="font-size:11px;color:var(--gold);text-transform:uppercase;letter-spacing:1px;font-weight:500;">{{ $product->category->nama_kategori }}</span>
            @endif
            <h1 style="font-size:28px;font-weight:600;color:var(--cream);margin:8px 0 12px;line-height:1.2;">{{ $product->nama_produk }}</h1>
            <div style="font-size:24px;font-weight:700;color:var(--gold);margin-bottom:16px;font-family:'Playfair Display',serif;">{{ number_format($product->harga,0,'.','.') }}</div>
            <p style="font-size:14px;color:var(--cream-muted);line-height:1.7;margin-bottom:20px;">{{ $product->deskripsi }}</p>
            <div style="display:flex;gap:16px;margin-bottom:20px;flex-wrap:wrap;">
                <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:var(--cream-muted);">
                    <i data-lucide="package" style="width:14px;height:14px;color:var(--gold);"></i> Stok: <strong style="color:{{ $product->stok > 0 ? 'var(--cream)' : '#f87171' }};">{{ $product->stok }} pcs</strong>
                </div>
                @if($product->umur_simpan)
                <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:var(--cream-muted);">
                    <i data-lucide="clock" style="width:14px;height:14px;color:var(--gold);"></i> Tahan {{ $product->umur_simpan }} hari
                </div>
                @endif
                @if($product->is_fragile)
                <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#fca5a5;">
                    <i data-lucide="alert-triangle" style="width:14px;height:14px;"></i> Mudah hancur
                </div>
                @endif
            </div>

            @if($product->stok > 0 && auth()->check())
            <form method="POST" action="{{ route('cart.add', $product) }}" style="border-top:1px solid rgba(201,169,110,0.06);padding-top:20px;">
                @csrf
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;">
                    <label class="form-label" style="margin-bottom:0;">Jumlah</label>
                    <input type="number" name="qty" value="1" min="1" max="{{ $product->stok }}" class="form-input" style="width:80px;text-align:center;padding:8px;">
                </div>
                <div style="margin-bottom:16px;">
                    <label class="form-label">Catatan (opsional)</label>
                    <input type="text" name="catatan" class="form-input" placeholder="Contoh: Tulis Happy Birthday Budi" maxlength="255">
                </div>
                <button type="submit" class="btn-gold" style="width:100%;justify-content:center;padding:13px;">
                    <i data-lucide="shopping-bag" style="width:16px;height:16px;"></i> Tambah ke Keranjang
                </button>
            </form>
            @elseif($product->stok <= 0)
            <div style="border-top:1px solid rgba(201,169,110,0.06);padding-top:20px;">
                <button disabled style="width:100%;padding:13px;background:rgba(200,185,168,0.08);border:1px solid rgba(200,185,168,0.1);border-radius:10px;color:var(--cream-muted);font-size:13px;cursor:not-allowed;font-family:'Inter',sans-serif;">Stok Habis</button>
            </div>
            @else
            <div style="border-top:1px solid rgba(201,169,110,0.06);padding-top:20px;">
                <a href="{{ route('login') }}" class="btn-gold" style="width:100%;justify-content:center;padding:13px;text-decoration:none;">Masuk untuk Belanja</a>
            </div>
            @endif
        </div>
    </div>

    @if($related->isNotEmpty())
    <section style="margin-top:48px;">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
            <div style="width:40px;height:3px;background:var(--gold);border-radius:2px;"></div>
            <h2 style="font-size:20px;font-weight:600;color:var(--cream);">Serupa</h2>
        </div>
        <div class="p-grid" style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;">
            @foreach($related as $r)
            <a href="{{ route('products.show', $r) }}" class="p-card fade-up">
                <div class="p-img"><img src="{{ $r->image_url ?: 'https://picsum.photos/seed/rel'.$r->id.'/400/400.jpg' }}" loading="lazy"></div>
                <div style="padding:10px 12px 12px;">
                    <h4 style="font-size:13px;font-weight:500;color:var(--cream);margin-bottom:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $r->nama_produk }}</h4>
                    <span style="font-size:14px;font-weight:700;color:var(--gold);">{{ number_format($r->harga,0,'.','.') }}</span>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection