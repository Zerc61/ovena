@extends('layouts.app')

@section('content')
<style>
    /* --- CSS KHUSUS KERANJANG --- */
    .cart-item {
        background: linear-gradient(145deg, rgba(44,24,16,0.4) 0%, rgba(26,14,8,0.7) 100%);
        backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(201,169,110,0.08);
        border-radius: 16px;
        padding: 16px;
        display: flex;
        gap: 16px;
        transition: all 0.3s ease;
        position: relative;
    }
    .cart-item:hover {
        border-color: rgba(201,169,110,0.2);
        box-shadow: 0 8px 32px rgba(0,0,0,0.25);
    }
    
    /* Image Item */
    .cart-img-wrap {
        width: 84px; height: 84px; flex-shrink: 0;
        border-radius: 12px; overflow: hidden;
        border: 1px solid rgba(201,169,110,0.1);
        background: rgba(26,14,8,0.8);
    }
    .cart-img-wrap img { width: 100%; height: 100%; object-fit: cover; }

    /* Quantity Pill */
    .qty-pill {
        display: inline-flex; align-items: center;
        background: rgba(26,14,8,0.6);
        border: 1px solid rgba(201,169,110,0.15);
        border-radius: 20px;
        overflow: hidden; margin-top: 8px;
    }
    .qty-btn {
        width: 32px; height: 32px; background: transparent; border: none;
        color: var(--cream); font-size: 16px; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.2s;
    }
    .qty-btn:hover:not(:disabled) { background: rgba(201,169,110,0.15); color: var(--gold); }
    .qty-btn:disabled { opacity: 0.3; cursor: not-allowed; }
    .qty-val {
        width: 28px; text-align: center; font-size: 13px; font-weight: 600; color: var(--cream);
    }

    /* Trash Button */
    .btn-trash {
        position: absolute; top: 16px; right: 16px;
        color: rgba(200,185,168,0.3); background: transparent; border: none;
        cursor: pointer; padding: 6px; border-radius: 8px;
        transition: all 0.2s; display: flex; align-items: center; justify-content: center;
    }
    .btn-trash:hover {
        color: #ef4444; background: rgba(239,68,68,0.1);
    }

    /* Panel Summary */
    .cart-summary {
        background: rgba(44,24,16,0.6); backdrop-filter: blur(16px);
        border: 1px solid rgba(201,169,110,0.15); border-radius: 16px;
        padding: 20px 24px; margin-top: 24px;
        display: flex; align-items: center; justify-content: space-between;
        box-shadow: 0 12px 40px rgba(0,0,0,0.2);
    }
    .summary-title { font-size: 13px; color: var(--cream-muted); text-transform: uppercase; letter-spacing: 1px; }
    .summary-total { font-size: 26px; font-weight: 700; color: var(--gold); font-family: 'Playfair Display', serif; line-height: 1.2; }

    /* Tombol Teks Bening (Clear Cart) */
    .btn-text-danger {
        background: transparent; border: none; color: rgba(239,68,68,0.7);
        font-size: 13px; font-family: 'Inter', sans-serif; font-weight: 500; cursor: pointer;
        transition: all 0.2s; text-decoration: underline; text-underline-offset: 4px;
    }
    .btn-text-danger:hover { color: #ef4444; }

    @media(max-width: 640px) {
        .cart-summary { flex-direction: column; align-items: stretch; gap: 16px; padding: 16px; }
        .summary-actions { display: flex; flex-direction: column; gap: 12px; }
        .summary-actions > form { align-self: center; }
        .cart-item { padding-right: 48px; /* Ruang untuk tombol hapus */ }
    }
</style>

<div style="max-width:800px; margin:0 auto; padding:28px 20px 60px;">
    
    <div style="display:flex; align-items:center; gap:12px; margin-bottom:28px;">
        <div style="width:40px; height:3px; background:var(--gold); border-radius:2px;"></div>
        <h1 style="font-size:24px; font-weight:600; color:var(--cream); font-family:'Playfair Display', serif;">Keranjang Belanja</h1>
    </div>

    @if(empty($cart))
    <div style="text-align:center; padding:80px 20px; background:rgba(26,14,8,0.4); border-radius:16px; border:1px dashed rgba(201,169,110,0.15);">
        <div style="width:64px; height:64px; background:rgba(201,169,110,0.05); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
            <i data-lucide="shopping-bag" style="width:32px; height:32px; color:var(--gold); opacity:0.6;"></i>
        </div>
        <p style="font-size:15px; color:var(--cream); font-weight:500; margin-bottom:6px;">Keranjangmu masih kosong</p>
        <p style="font-size:13px; color:var(--cream-muted); margin-bottom:20px;">Temukan roti dan pastry artisan favoritmu sekarang.</p>
        <a href="/home" class="btn-gold">Mulai Belanja</a>
    </div>
    @else
    
    <div style="display:flex; flex-direction:column; gap:12px;">
        @foreach($cart as $id => $item)
        <div class="cart-item">
            <a href="{{ route('products.show', $item['id']) }}" class="cart-img-wrap">
                @php $cartImg = \Illuminate\Support\Facades\Storage::url($item['gambar']) ?? $item['gambar'] ?: 'https://picsum.photos/seed/cart'.$id.'/100/100.jpg'; @endphp
                <img src="{{ $cartImg }}" alt="{{ $item['nama'] }}">
            </a>
            
            <div style="flex:1; min-width:0; display:flex; flex-direction:column; justify-content:center;">
                <a href="{{ route('products.show', $item['id']) }}" style="font-size:16px; font-weight:600; color:var(--cream); text-decoration:none; font-family:'Playfair Display', serif; display:block; margin-bottom:4px; padding-right:32px;">
                    {{ $item['nama'] }}
                </a>
                
                <div style="font-size:13px; color:var(--cream-muted); margin-bottom:4px;">
                    {{ number_format($item['harga'], 0, '.', '.') }} <span style="font-size:11px; opacity:0.6;">/ item</span>
                </div>

                @if($item['catatan'])
                    <div style="font-size:11px; color:var(--gold); opacity:0.8; font-style:italic; margin-bottom:6px;">
                        <i data-lucide="pen-line" style="width:10px; height:10px; display:inline-block; vertical-align:middle; margin-right:2px;"></i>
                        {{ $item['catatan'] }}
                    </div>
                @endif
                
                <div style="display:flex; align-items:flex-end; justify-content:space-between; margin-top:auto;">
                    
                    <form method="POST" action="{{ route('cart.update') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}">
                        <div class="qty-pill">
                            <button type="submit" name="qty" value="{{ $item['qty'] - 1 }}" class="qty-btn" title="Kurangi">−</button>
                            <span class="qty-val">{{ $item['qty'] }}</span>
                            <button type="submit" name="qty" value="{{ $item['qty'] + 1 }}" @if($item['qty'] >= $item['stok']) disabled @endif class="qty-btn" title="Tambah">+</button>
                        </div>
                    </form>

                    <div style="text-align:right;">
                        <div style="font-size:10px; color:rgba(200,185,168,0.4); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:2px;">Subtotal</div>
                        <div style="font-size:16px; font-weight:700; color:var(--gold);">
                            {{ number_format($item['harga'] * $item['qty'], 0, '.', '.') }}
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('cart.remove') }}" onsubmit="return confirm('Hapus item ini dari keranjang?')" style="position:absolute; top:12px; right:12px;">
                @csrf
                <input type="hidden" name="id" value="{{ $id }}">
                <button type="submit" class="btn-trash" title="Hapus Item">
                    <i data-lucide="trash-2" style="width:16px; height:16px;"></i>
                </button>
            </form>
        </div>
        @endforeach
    </div>

    <div class="cart-summary">
        <div>
            <div class="summary-title">Total Belanja ({{ collect($cart)->sum('qty') }} item)</div>
            <div class="summary-total">Rp {{ number_format($total, 0, '.', '.') }}</div>
        </div>
        
        <div class="summary-actions" style="display:flex; align-items:center; gap:20px;">
            <form method="POST" action="{{ route('cart.clear') }}" onsubmit="return confirm('Yakin ingin mengosongkan semua isi keranjang?')">
                @csrf
                <button type="submit" class="btn-text-danger">Kosongkan Keranjang</button>
            </form>
            <a href="{{ route('checkout.index') }}" class="btn-gold" style="padding:14px 32px; font-size:14px;">
                Lanjut Checkout <i data-lucide="arrow-right" style="width:16px; height:16px;"></i>
            </a>
        </div>
    </div>
    @endif
</div>
@endsection