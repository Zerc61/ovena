@extends('layouts.app')
@section('content')
<div style="max-width:1200px;margin:0 auto;padding:20px 20px 0;">

    {{-- Best Seller --}}
    @if($bestSellers->isNotEmpty())
    <section style="margin-bottom:28px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:40px;height:3px;background:var(--gold);border-radius:2px;"></div>
                <h2 style="font-size:20px;font-weight:600;color:var(--cream);">Best Seller</h2>
            </div>
        </div>
        <div class="p-grid" style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;">
            @foreach($bestSellers as $p)
           @php $img = $p->image_url ?: 'https://picsum.photos/seed/default'.$p->id.'/400/400.jpg'; @endphp
            <a href="{{ route('products.show', $p) }}" class="p-card fade-up">
                <div class="p-img">
                    <img src="{{ $img }}" alt="{{ $p->nama_produk }}" loading="lazy">
                    @if($p->stok <= 0)<div class="p-stock-out"><span>Habis</span></div>@endif
                    <button class="p-wish" onclick="event.preventDefault();"><i data-lucide="heart" style="width:14px;height:14px;"></i></button>
                </div>
                <div style="padding:10px 12px 12px;">
                    <div style="display:flex;align-items:center;gap:4px;margin-bottom:4px;">
                        <span style="color:var(--gold);font-size:10px;">★</span>
                        <span style="font-size:11px;color:var(--cream-muted);">Best Seller</span>
                    </div>
                    <h4 style="font-size:13px;font-weight:500;color:var(--cream);margin-bottom:6px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $p->nama_produk }}</h4>
                    <span style="font-size:15px;font-weight:700;color:var(--gold);">{{ number_format($p->harga,0,'.','.') }}</span>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Kategori --}}
    <section style="margin-bottom:28px;">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
            <div style="width:40px;height:3px;background:var(--gold);border-radius:2px;"></div>
            <h2 style="font-size:20px;font-weight:600;color:var(--cream);">Kategori</h2>
        </div>
        <div class="cat-grid" style="display:grid;grid-template-columns:repeat(8,1fr);gap:6px;">
            <a href="/home" class="cat-card {{ !request('kategori') ? 'active' : '' }}">
                <div class="cat-icon-wrap"><i data-lucide="grid-2x2" style="width:20px;height:20px;color:var(--gold);"></i></div>
                <span class="cat-label" style="font-size:11px;font-weight:500;color:var(--cream-muted);text-align:center;">Semua</span>
            </a>
            @foreach($categories as $cat)
            <a href="/home?kategori={{ $cat->id }}" class="cat-card {{ request('kategori') == $cat->id ? 'active' : '' }}">
                <div class="cat-icon-wrap"><i data-lucide="wheat" style="width:20px;height:20px;color:var(--gold);"></i></div>
                <span class="cat-label" style="font-size:11px;font-weight:500;color:var(--cream-muted);text-align:center;line-height:1.3;">{{ $cat->nama_kategori }}</span>
            </a>
            @endforeach
        </div>
    </section>

    {{-- Semua Produk --}}
    <section style="margin-bottom:40px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:40px;height:3px;background:var(--gold);border-radius:2px;"></div>
                <h2 style="font-size:20px;font-weight:600;color:var(--cream);">Semua Produk</h2>
                <span style="font-size:12px;color:rgba(200,185,168,0.35);">({{ $products->total() }})</span>
            </div>
        </div>
        @if($products->isEmpty())
        <div style="text-align:center;padding:60px 20px;color:var(--cream-muted);opacity:.4;">
            <i data-lucide="search-x" style="width:40px;height:40px;margin:0 auto 12px;display:block;"></i>
            <p>Produk tidak ditemukan.</p>
        </div>
        @else
        <div class="p-grid" style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;">
            @foreach($products as $p)
          @php $img = $p->image_url ?: 'https://picsum.photos/seed/default'.$p->id.'/400/400.jpg'; @endphp
            <a href="{{ route('products.show', $p) }}" class="p-card fade-up">
                <div class="p-img">
                    <img src="{{ $img }}" alt="{{ $p->nama_produk }}" loading="lazy">
                    @if($p->stok <= 0)<div class="p-stock-out"><span>Habis</span></div>@endif
                    @if($p->is_fragile && $p->stok > 0)<span style="position:absolute;top:8px;left:8px;padding:2px 8px;border-radius:5px;font-size:9px;font-weight:600;background:rgba(201,169,110,0.12);color:var(--gold-light);text-transform:uppercase;letter-spacing:.3px;">Fragile</span>@endif
                </div>
                <div style="padding:10px 12px 12px;">
                    @if($p->category)
                    <div style="font-size:10px;color:rgba(200,185,168,0.3);margin-bottom:3px;">{{ $p->category->nama_kategori }}</div>
                    @endif
                    <h4 style="font-size:13px;font-weight:500;color:var(--cream);margin-bottom:6px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;line-height:1.35;">{{ $p->nama_produk }}</h4>
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <span style="font-size:15px;font-weight:700;color:var(--gold);">{{ number_format($p->harga,0,'.','.') }}</span>
                        <span style="font-size:11px;color:rgba(200,185,168,0.3);">Stok: {{ $p->stok }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <div style="display:flex;justify-content:center;margin-top:24px;">
            {{ $products->links() }}
        </div>
        @endif
    </section>
</div>
@endsection