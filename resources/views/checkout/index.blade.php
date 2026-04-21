@extends('layouts.app')
@section('content')
<div style="max-width:900px;margin:0 auto;padding:28px 20px 40px;">
    <a href="{{ route('cart.index') }}" style="display:inline-flex;align-items:center;gap:4px;font-size:13px;color:var(--cream-muted);text-decoration:none;margin-bottom:20px;opacity:.5;"><i data-lucide="arrow-left" style="width:14px;height:14px;"></i> Kembali ke Keranjang</a>
    <h1 style="font-size:24px;font-weight:600;color:var(--cream);margin-bottom:24px;">Checkout</h1>
    <form method="POST" action="{{ route('checkout.process') }}">
        @csrf
        <div style="display:grid;grid-template-columns:1.3fr 1fr;gap:24px;">
            <div style="display:flex;flex-direction:column;gap:18px;">
                <div style="background:rgba(44,24,16,0.5);border:1px solid rgba(201,169,110,0.06);border-radius:14px;padding:20px;">
                    <h3 style="font-size:15px;font-weight:600;color:var(--cream);margin-bottom:16px;">Info Pengiriman</h3>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                        <div><label class="form-label">Nama Penerima</label><input class="form-input" name="nama_penerima" value="{{ $user->nama }}" required></div>
                        <div><label class="form-label">No. Telepon</label><input class="form-input" name="no_telp_penerima" value="{{ $user->no_telp or old('no_telp_penerima') }}" required></div>
                    </div>
                    <div style="margin-top:14px;"><label class="form-label">Alamat Pengiriman</label><textarea class="form-input" name="alamat_pengiriman" rows="3" required style="resize:none;font-family:'Inter',sans-serif;">{{ $user->alamat_pengiriman }}</textarea></div>
                    <div style="margin-top:14px;"><label class="form-label">Catatan (opsional)</label><input class="form-input" name="catatan" placeholder="Catatan tambahan untuk pesanan"></div>
                </div>
                <div style="background:rgba(44,24,16,0.5);border:1px solid rgba(201,169,110,0.06);border-radius:14px;padding:20px;">
                    <h3 style="font-size:15px;font-weight:600;color:var(--cream);margin-bottom:14px;">Metode Pembayaran</h3>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;" id="payGrid">
                        @foreach(['transfer'=>'Transfer Bank','ewallet'=>'E-Wallet','cod'=>'COD','qris'=>'QRIS'] as $val => $label)
                        <label class="pay-opt {{ old('metode_pembayaran',$val) == $val ? 'selected' : '' }}" onclick="selectPay(this)">
                            <input type="radio" name="metode_pembayaran" value="{{ $val }}" {{ old('metode_pembayaran',$val) == $val ? 'checked' : ($loop->first ? 'checked' : '') }} style="display:none;">
                            <span style="font-size:12px;color:var(--cream-muted);">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
            <div>
                <div style="background:rgba(44,24,16,0.5);border:1px solid rgba(201,169,110,0.06);border-radius:14px;padding:20px;position:sticky;top:80px;">
                    <h3 style="font-size:15px;font-weight:600;color:var(--cream);margin-bottom:14px;">Ringkasan</h3>
                    <div style="max-height:200px;overflow-y:auto;margin-bottom:14px;">
                        @foreach($cart as $item)
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                            <span style="font-size:12px;color:var(--cream-muted);flex:1;margin-right:8px;">{{ $item['nama'] }} x{{ $item['qty'] }}</span>
                            <span style="font-size:12px;font-weight:600;color:var(--cream);flex-shrink:0;">{{ number_format($item['harga'] * $item['qty'],0,'.','.') }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div style="border-top:1px solid rgba(201,169,110,0.08);padding-top:12px;display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                        <span style="font-size:15px;font-weight:600;color:var(--cream);">Total</span>
                        <span style="font-size:20px;font-weight:700;color:var(--gold);font-family:'Playfair Display',serif;">{{ number_format($total,0,'.','.') }}</span>
                    </div>
                    <button type="submit" class="btn-gold" style="width:100%;justify-content:center;padding:13px;">Bayar Sekarang</button>
                </div>
            </div>
        </div>
    </form>
</div>
@push('scripts')
<script>
function selectPay(el){document.querySelectorAll('.pay-opt').forEach(o=>o.classList.remove('selected'));el.classList.add('selected');el.querySelector('input').checked=true;}
</script>
@endpush
@endsection