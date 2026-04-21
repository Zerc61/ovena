@extends('layouts.app')
@section('content')
<div style="max-width:900px;margin:0 auto;padding:28px 20px 40px;">
    <h1 style="font-size:24px;font-weight:600;color:var(--cream);margin-bottom:24px;">Keranjang</h1>
    @if(empty($cart))
    <div style="text-align:center;padding:60px 20px;color:var(--cream-muted);opacity:.4;">
        <i data-lucide="shopping-bag" style="width:48px;height:48px;margin:0 auto 12px;display:block;"></i>
        <p style="font-size:15px;">Keranjang masih kosong</p>
        <a href="/home" class="btn-outline" style="margin-top:16px;display:inline-flex;">Mulai Belanja</a>
    </div>
    @else
    <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:20px;">
        @foreach($cart as $id => $item)
        <div style="display:flex;gap:14px;padding:14px;background:rgba(44,24,16,0.45);border:1px solid rgba(201,169,110,0.06);border-radius:12px;">
            <a href="{{ route('products.show', $item['id']) }}" style="flex-shrink:0;">
    @php $cartImg = \Illuminate\Support\Facades\Storage::url($item['gambar']) ?? $item['gambar'] ?: 'https://picsum.photos/seed/cart'.$id.'/100/100.jpg'; @endphp
    <img src="{{ $cartImg }}" style="width:72px;height:72px;border-radius:10px;object-fit:cover;">
</a>
            <div style="flex:1;min-width:0;">
                <a href="{{ route('products.show', $item['id']) }}" style="font-size:14px;font-weight:500;color:var(--cream);text-decoration:none;">{{ $item['nama'] }}</a>
                @if($item['catatan'])<div style="font-size:11px;color:var(--gold);opacity:.6;margin-top:2px;">Catatan: {{ $item['catatan'] }}</div>@endif
                <div style="font-size:14px;font-weight:700;color:var(--gold);margin-top:4px;">{{ number_format($item['harga'],0,'.','.') }}</div>
                <div style="display:flex;align-items:center;justify-content:space-between;margin-top:8px;">
                    <form method="POST" action="{{ route('cart.update') }}" style="display:flex;align-items:center;gap:5px;">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}">
                        <button type="submit" name="qty" value="{{ $item['qty'] - 1 }}" style="width:28px;height:28px;border-radius:7px;border:1px solid rgba(201,169,110,0.12);background:rgba(44,24,16,0.6);color:var(--cream);cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center;">−</button>
                        <span style="font-size:13px;font-weight:600;min-width:24px;text-align:center;color:var(--cream);">{{ $item['qty'] }}</span>
                        <button type="submit" name="qty" value="{{ $item['qty'] + 1 }}" @if($item['qty'] >= $item['stok']) disabled style="opacity:.3;" @endif style="width:28px;height:28px;border-radius:7px;border:1px solid rgba(201,169,110,0.12);background:rgba(44,24,16,0.6);color:var(--cream);cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center;">+</button>
                    </form>
                    <form method="POST" action="{{ route('cart.remove') }}" onsubmit="return confirm('Hapus item ini?')">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}">
                        <button type="submit" style="background:none;border:none;cursor:pointer;color:var(--cream-muted);opacity:.3;"><i data-lucide="trash-2" style="width:15px;height:15px;"></i></button>
                    </form>
                </div>
            </div>
            <div style="font-size:14px;font-weight:600;color:var(--cream);flex-shrink:0;align-self:center;">{{ number_format($item['harga'] * $item['qty'],0,'.','.') }}</div>
        </div>
        @endforeach
    </div>
    <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 20px;background:rgba(44,24,16,0.5);border:1px solid rgba(201,169,110,0.08);border-radius:14px;">
        <div>
            <span style="font-size:13px;color:var(--cream-muted);">Total ({{ collect($cart)->sum('qty') }} item)</span>
            <div style="font-size:22px;font-weight:700;color:var(--gold);font-family:'Playfair Display',serif;margin-top:2px;">{{ number_format($total,0,'.','.') }}</div>
        </div>
        <div style="display:flex;gap:10px;">
            <form method="POST" action="{{ route('cart.clear') }}" onsubmit="return confirm('Kosongkan keranjang?')">
                @csrf
                <button type="submit" class="btn-danger">Kosongkan</button>
            </form>
            <a href="{{ route('checkout.index') }}" class="btn-gold" style="padding:13px 28px;">Checkout</a>
        </div>
    </div>
    @endif
</div>
@endsection