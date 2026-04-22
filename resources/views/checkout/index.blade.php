@extends('layouts.app')
@section('content')
<div style="max-width:900px;margin:0 auto;padding:28px 20px 40px;">
    <a href="{{ route('cart.index') }}" style="display:inline-flex;align-items:center;gap:4px;font-size:13px;color:var(--cream-muted);text-decoration:none;margin-bottom:20px;opacity:.5;"><i data-lucide="arrow-left" style="width:14px;height:14px;"></i> Kembali ke Keranjang</a>
    <h1 style="font-size:24px;font-weight:600;color:var(--cream);margin-bottom:24px;">Checkout</h1>
    
    {{-- Form Checkout Utama --}}
    <form method="POST" action="{{ route('checkout.process') }}" id="checkout-form">
        @csrf
        <div style="display:grid;grid-template-columns:1.3fr 1fr;gap:24px;">
            
            {{-- Kolom Kiri: Info & Pembayaran --}}
            <div style="display:flex;flex-direction:column;gap:18px;">
                <div style="background:rgba(44,24,16,0.5);border:1px solid rgba(201,169,110,0.06);border-radius:14px;padding:20px;">
                    <h3 style="font-size:15px;font-weight:600;color:var(--cream);margin-bottom:16px;">Info Pengiriman</h3>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                        <div><label class="form-label">Nama Penerima</label><input class="form-input" name="nama_penerima" value="{{ old('nama_penerima', $user->nama) }}" required></div>
                        <div><label class="form-label">No. Telepon</label><input class="form-input" name="no_telp_penerima" value="{{ old('no_telp_penerima', $user->no_telp) }}" required></div>
                    </div>
                    <div style="margin-top:14px;"><label class="form-label">Alamat Pengiriman</label><textarea class="form-input" name="alamat_pengiriman" rows="3" required style="resize:none;font-family:'Inter',sans-serif;">{{ old('alamat_pengiriman', $user->alamat_pengiriman) }}</textarea></div>
                    <div style="margin-top:14px;"><label class="form-label">Catatan (opsional)</label><input class="form-input" name="catatan" value="{{ old('catatan') }}" placeholder="Catatan tambahan untuk pesanan"></div>
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
            
            {{-- Kolom Kanan: Voucher & Ringkasan --}}
            <div>
                <div style="position:sticky;top:80px;display:flex;flex-direction:column;gap:16px;">
                    
                    {{-- Kotak Voucher Diskon --}}
                    <div style="background:rgba(44,24,16,0.5);border:1px solid rgba(201,169,110,0.06);border-radius:14px;padding:20px;">
                        <h3 style="font-size:14px;font-weight:600;color:var(--cream);margin-bottom:12px;display:flex;align-items:center;gap:6px;">
                            <i data-lucide="ticket" style="width:16px;height:16px;color:var(--gold);"></i> Punya Kode Voucher?
                        </h3>
                        
                        @if($voucher)
                            <div style="background:rgba(74,222,128,0.1);border:1px dashed #4ade80;border-radius:8px;padding:12px;display:flex;align-items:center;justify-content:space-between;">
                                <div>
                                    <div style="font-size:12px;font-weight:600;color:#4ade80;">{{ $voucher->kode_voucher }}</div>
                                    <div style="font-size:11px;color:var(--cream-muted);margin-top:2px;">Voucher berhasil diterapkan</div>
                                </div>
                                <button type="button" onclick="document.getElementById('remove-voucher-form').submit();" style="background:none;border:none;color:#fca5a5;cursor:pointer;font-size:11px;text-decoration:underline;">Batalkan</button>
                            </div>
                        @else
                            <div style="display:flex;gap:8px;">
                                <input type="text" id="kode_voucher_input" class="form-input" placeholder="Masukkan kode" style="text-transform:uppercase;">
                                <button type="button" onclick="applyVoucher()" class="btn-outline" style="flex-shrink:0;">Terapkan</button>
                            </div>
                        @endif
                    </div>

                    {{-- Kotak Ringkasan --}}
                    <div style="background:rgba(44,24,16,0.5);border:1px solid rgba(201,169,110,0.06);border-radius:14px;padding:20px;">
                        <h3 style="font-size:15px;font-weight:600;color:var(--cream);margin-bottom:14px;">Ringkasan</h3>
                        <div style="max-height:200px;overflow-y:auto;margin-bottom:14px;">
                            @foreach($cart as $item)
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                                <span style="font-size:12px;color:var(--cream-muted);flex:1;margin-right:8px;">{{ $item['nama'] }} x{{ $item['qty'] }}</span>
                                <span style="font-size:12px;font-weight:600;color:var(--cream);flex-shrink:0;">{{ number_format($item['harga'] * $item['qty'],0,'.','.') }}</span>
                            </div>
                            @endforeach
                        </div>
                        
                        <div style="border-top:1px solid rgba(201,169,110,0.08);padding-top:12px;display:flex;flex-direction:column;gap:8px;margin-bottom:16px;">
                            <div style="display:flex;justify-content:space-between;align-items:center;">
                                <span style="font-size:13px;color:var(--cream-muted);">Subtotal</span>
                                <span style="font-size:13px;color:var(--cream);">{{ number_format($totalBelanja,0,'.','.') }}</span>
                            </div>
                            
                            @if($diskon > 0)
                            <div style="display:flex;justify-content:space-between;align-items:center;">
                                <span style="font-size:13px;color:#4ade80;">Diskon Voucher</span>
                                <span style="font-size:13px;color:#4ade80;">- {{ number_format($diskon,0,'.','.') }}</span>
                            </div>
                            @endif
                            
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-top:8px;padding-top:8px;border-top:1px dashed rgba(201,169,110,0.2);">
                                <span style="font-size:15px;font-weight:600;color:var(--cream);">Total Akhir</span>
                                <span style="font-size:20px;font-weight:700;color:var(--gold);font-family:'Playfair Display',serif;">{{ number_format($totalAkhir,0,'.','.') }}</span>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn-gold" style="width:100%;justify-content:center;padding:13px;">Bayar Sekarang</button>
                    </div>
                </div>
            </div>
            
        </div>
    </form>

    {{-- Form Tersembunyi untuk Aksi Voucher (Letaknya harus di luar form checkout utama) --}}
    <form id="apply-voucher-form" method="POST" action="{{ route('checkout.voucher.apply') }}" style="display:none;">
        @csrf
        <input type="hidden" name="kode_voucher" id="hidden_voucher_code">
    </form>
    <form id="remove-voucher-form" method="POST" action="{{ route('checkout.voucher.remove') }}" style="display:none;">
        @csrf
    </form>

</div>

@push('scripts')
<script>
function selectPay(el) {
    document.querySelectorAll('.pay-opt').forEach(o => o.classList.remove('selected'));
    el.classList.add('selected');
    el.querySelector('input').checked = true;
}

// Fungsi untuk mengirimkan kode voucher
function applyVoucher() {
    const input = document.getElementById('kode_voucher_input').value;
    if(input.trim() === '') return alert('Masukkan kode voucher terlebih dahulu!');
    
    document.getElementById('hidden_voucher_code').value = input;
    document.getElementById('apply-voucher-form').submit();
}
</script>
@endpush
@endsection