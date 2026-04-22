@extends('layouts.app')

@section('content')
<style>
    /* --- CSS KHUSUS HALAMAN PEMBAYARAN --- */
    .payment-wrapper {
        max-width: 600px; margin: 0 auto; padding: 40px 20px 80px;
    }
    
    /* Header & Timer */
    .status-pill {
        display: inline-flex; align-items: center; gap: 8px;
        background: rgba(201, 169, 110, 0.1); border: 1px solid rgba(201, 169, 110, 0.2);
        padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;
        color: var(--gold); margin-bottom: 24px;
    }
    .pulse-dot {
        width: 8px; height: 8px; background: var(--gold); border-radius: 50%;
        animation: pulseGold 1.5s infinite;
    }
    @keyframes pulseGold {
        0% { box-shadow: 0 0 0 0 rgba(201,169,110,0.4); }
        70% { box-shadow: 0 0 0 6px rgba(201,169,110,0); }
        100% { box-shadow: 0 0 0 0 rgba(201,169,110,0); }
    }
    
    .timer-box {
        background: linear-gradient(to right, rgba(74,18,18,0.4), rgba(44,24,16,0.6));
        border-left: 3px solid #ef4444; border-radius: 8px;
        padding: 16px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between;
    }

    /* Main Card */
    .pay-card {
        background: linear-gradient(145deg, rgba(44,24,16,0.5) 0%, rgba(26,14,8,0.8) 100%);
        backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(201,169,110,0.15);
        border-radius: 20px; padding: 32px; box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        position: relative; overflow: hidden;
    }
    .pay-card::before { /* Glow effect atas */
        content: ''; position: absolute; top: 0; left: 50%; transform: translateX(-50%);
        width: 60%; height: 1px; background: linear-gradient(90deg, transparent, var(--gold), transparent);
    }

    /* QRIS Styles */
    .qr-wrapper {
        background: #ffffff; padding: 20px; border-radius: 16px; display: inline-block;
        position: relative; overflow: hidden; box-shadow: 0 10px 24px rgba(0,0,0,0.4);
        border: 4px solid rgba(201,169,110,0.3); margin-bottom: 24px;
    }
    .qr-scan-line {
        position: absolute; top: 0; left: 0; width: 100%; height: 4px;
        background: rgba(34, 197, 94, 0.8); box-shadow: 0 0 12px rgba(34, 197, 94, 0.8);
        animation: scan 2.5s infinite linear;
    }
    @keyframes scan {
        0% { top: 10px; opacity: 0; }
        10% { opacity: 1; }
        90% { opacity: 1; }
        100% { top: calc(100% - 10px); opacity: 0; }
    }

    /* VA Styles */
    .va-card {
        background: linear-gradient(135deg, rgba(201,169,110,0.15), rgba(26,14,8,0.8));
        border: 1px solid rgba(201,169,110,0.25); border-radius: 14px; padding: 20px;
        margin-bottom: 24px; text-align: left; position: relative;
    }
    .copy-btn {
        background: rgba(201,169,110,0.2); color: var(--gold); border: none;
        padding: 6px 12px; border-radius: 6px; font-size: 11px; font-weight: 600;
        cursor: pointer; display: inline-flex; align-items: center; gap: 4px; transition: all 0.2s;
    }
    .copy-btn:hover { background: var(--gold); color: var(--brown-deep); }

    /* Instructions */
    .instruction-list {
        text-align: left; background: rgba(26,14,8,0.4); border-radius: 12px; padding: 20px;
    }
    .step-item {
        display: flex; gap: 12px; margin-bottom: 12px; font-size: 13px; color: var(--cream-muted); line-height: 1.5;
    }
    .step-item:last-child { margin-bottom: 0; }
    .step-num {
        width: 20px; height: 20px; flex-shrink: 0; border-radius: 50%;
        background: rgba(201,169,110,0.1); color: var(--gold); font-size: 11px; font-weight: 700;
        display: flex; align-items: center; justify-content: center; border: 1px solid rgba(201,169,110,0.2);
    }

    /* Total Section */
    .receipt-total {
        border-top: 1px dashed rgba(201,169,110,0.3); margin-top: 28px; padding-top: 24px;
        display: flex; justify-content: space-between; align-items: flex-end; text-align: left;
    }
</style>

<div class="payment-wrapper">
    <div style="text-align:center;">
        <div class="status-pill">
            <div class="pulse-dot"></div> Menunggu Pembayaran
        </div>
        <h1 style="font-size:28px; font-weight:600; color:var(--cream); font-family:'Playfair Display', serif; margin-bottom:8px;">Selesaikan Pesanan</h1>
        <p style="font-size:14px; color:var(--cream-muted); margin-bottom:28px;">Order ID: <span style="color:var(--gold); font-family:monospace; font-weight:600;">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span></p>
    </div>

    <div class="timer-box">
        <div>
            <div style="font-size:12px; color:rgba(200,185,168,0.7); margin-bottom:4px;">Batas Waktu Pembayaran</div>
            <div style="font-size:14px; font-weight:600; color:var(--cream);">Besok, 23:59 WIB</div>
        </div>
        <div style="text-align:right;">
            <div style="font-size:18px; font-weight:700; color:#ef4444; font-family:monospace; letter-spacing:1px;" id="countdown">23:59:59</div>
        </div>
    </div>

    <div class="pay-card">
        
        <div style="text-align:center;">
            
            {{-- TAMPILAN JIKA MEMILIH QRIS --}}
            @if($order->metode_pembayaran === 'qris')
                <div style="display:flex; align-items:center; justify-content:center; gap:8px; margin-bottom:24px;">
                    <i data-lucide="qr-code" style="color:var(--gold); width:24px; height:24px;"></i>
                    <h3 style="font-size:18px; font-weight:600; color:var(--cream);">Scan QRIS</h3>
                </div>
                
                <div class="qr-wrapper">
                    <div class="qr-scan-line"></div>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=DUMMY-PAYMENT-{{ $order->id }}" alt="QRIS" style="width:200px; height:200px; display:block;">
                </div>
                
                <div style="display:flex; justify-content:center; gap:12px; margin-bottom:24px; opacity:0.6;">
                    <div style="font-size:11px; font-weight:600; border:1px solid #ccc; padding:2px 8px; border-radius:4px; color:#333; background:#fff;">Gopay</div>
                    <div style="font-size:11px; font-weight:600; border:1px solid #ccc; padding:2px 8px; border-radius:4px; color:#333; background:#fff;">OVO</div>
                    <div style="font-size:11px; font-weight:600; border:1px solid #ccc; padding:2px 8px; border-radius:4px; color:#333; background:#fff;">ShopeePay</div>
                    <div style="font-size:11px; font-weight:600; border:1px solid #ccc; padding:2px 8px; border-radius:4px; color:#333; background:#fff;">BCA</div>
                </div>

                <div class="instruction-list">
                    <div class="step-item"><div class="step-num">1</div> Buka aplikasi e-wallet atau m-banking yang mendukung QRIS.</div>
                    <div class="step-item"><div class="step-num">2</div> Pilih menu Scan QR / Bayar.</div>
                    <div class="step-item"><div class="step-num">3</div> Arahkan kamera ke QR Code di atas.</div>
                    <div class="step-item"><div class="step-num">4</div> Pastikan nama merchant adalah <strong>Ovena Bakery</strong> dan nominal sesuai.</div>
                </div>

            {{-- TAMPILAN JIKA MEMILIH TRANSFER BANK --}}
            @elseif($order->metode_pembayaran === 'transfer')
                <div style="display:flex; align-items:center; justify-content:center; gap:8px; margin-bottom:24px;">
                    <i data-lucide="building" style="color:var(--gold); width:24px; height:24px;"></i>
                    <h3 style="font-size:18px; font-weight:600; color:var(--cream);">Transfer Virtual Account</h3>
                </div>
                
                <div class="va-card">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                        <span style="font-size:13px; color:var(--cream-muted); font-weight:500;">Bank BCA</span>
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" alt="BCA" style="height:16px; opacity:0.8; filter:brightness(0) invert(1);">
                    </div>
                    <div style="font-size:28px; font-weight:700; color:var(--gold); letter-spacing:3px; margin-bottom:16px; font-family:monospace;" id="va-number">
                        8077 0812 3456
                    </div>
                    <div style="display:flex; align-items:center; justify-content:space-between;">
                        <span style="font-size:12px; color:var(--cream-muted);">A/N: <strong>Ovena Artisan Bakery</strong></span>
                        <button class="copy-btn" onclick="copyVA()">
                            <i data-lucide="copy" style="width:14px; height:14px;"></i> Salin
                        </button>
                    </div>
                </div>

                <div class="instruction-list">
                    <div class="step-item"><div class="step-num">1</div> Buka BCA Mobile, pilih m-Transfer > BCA Virtual Account.</div>
                    <div class="step-item"><div class="step-num">2</div> Masukkan nomor Virtual Account di atas.</div>
                    <div class="step-item"><div class="step-num">3</div> Pastikan total tagihan sudah sesuai.</div>
                    <div class="step-item"><div class="step-num">4</div> Masukkan PIN Anda untuk menyelesaikan pembayaran.</div>
                </div>

            {{-- TAMPILAN JIKA MEMILIH E-WALLET --}}
            @elseif($order->metode_pembayaran === 'ewallet')
                <div style="display:flex; align-items:center; justify-content:center; gap:8px; margin-bottom:24px;">
                    <i data-lucide="smartphone-nfc" style="color:var(--gold); width:24px; height:24px;"></i>
                    <h3 style="font-size:18px; font-weight:600; color:var(--cream);">Pembayaran E-Wallet</h3>
                </div>
                
                <div style="background:rgba(26,14,8,0.4); padding:32px 20px; border-radius:16px; margin-bottom:24px; border:1px solid rgba(201,169,110,0.1);">
                    <div style="width:72px; height:72px; background:rgba(201,169,110,0.1); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
                        <i data-lucide="wallet" style="width:36px; height:36px; color:var(--gold);"></i>
                    </div>
                    <p style="font-size:14px; color:var(--cream-muted); line-height:1.6; margin-bottom:24px;">
                        Selesaikan pembayaran langsung melalui aplikasi E-Wallet pilihan Anda. Transaksi ini dijamin aman.
                    </p>
                    <button style="background:var(--gold); color:var(--brown-deep); border:none; border-radius:10px; padding:14px 28px; font-weight:600; font-size:14px; cursor:pointer; width:100%; box-shadow:0 8px 24px rgba(201,169,110,0.3); transition:all 0.3s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                        Buka Aplikasi Pembayaran
                    </button>
                </div>

            {{-- TAMPILAN JIKA MEMILIH COD --}}
            @elseif($order->metode_pembayaran === 'cod')
                <div style="display:flex; align-items:center; justify-content:center; gap:8px; margin-bottom:24px;">
                    <i data-lucide="truck" style="color:var(--gold); width:24px; height:24px;"></i>
                    <h3 style="font-size:18px; font-weight:600; color:var(--cream);">Bayar di Tempat (COD)</h3>
                </div>
                
                <div style="background:rgba(26,14,8,0.4); border:1px solid rgba(201,169,110,0.1); border-radius:16px; padding:32px 20px; margin-bottom:24px;">
                    <img src="https://cdn-icons-png.flaticon.com/512/2769/2769339.png" style="width:80px; filter:sepia(1) hue-rotate(5deg) saturate(3) opacity(0.8); margin-bottom:20px;" alt="COD">
                    <h4 style="font-size:15px; color:var(--cream); margin-bottom:12px;">Pesanan Segera Dikirim</h4>
                    <p style="font-size:13px; color:var(--cream-muted); line-height:1.6;">
                        Mohon siapkan uang tunai sesuai dengan total tagihan. Kurir kami akan menghubungi Anda saat paket hampir sampai di lokasi.
                    </p>
                </div>
            @endif

        </div>

        <div class="receipt-total">
            <div>
                <div style="font-size:12px; color:var(--cream-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">Total Tagihan</div>
                <div style="font-size:11px; color:rgba(200,185,168,0.5);">Termasuk ongkos kirim</div>
            </div>
            <div style="text-align:right;">
                <div style="font-size:26px; font-weight:700; color:var(--gold); font-family:'Playfair Display', serif;">
                    Rp {{ number_format($order->total_harga, 0, '.', '.') }}
                </div>
            </div>
        </div>

        {{-- TOMBOL SIMULASI (Testing) --}}
      {{-- TOMBOL SIMULASI (Testing) --}}
        <form method="POST" action="{{ route('payment.simulate', $order->id) }}" style="margin-top:24px;">
            @csrf
            <button type="submit" class="btn-outline" style="width:100%; justify-content:center; padding:14px; font-size:13px; border-style:dashed;">
                <i data-lucide="check-circle" style="width:16px; height:16px;"></i> 
                @if($order->metode_pembayaran === 'cod')
                    Konfirmasi Pesanan COD
                @else
                    Simulasikan Sukses Bayar
                @endif
            </button>
        </form>

    </div>

    <div style="display:flex; align-items:center; justify-content:center; gap:8px; margin-top:24px; opacity:0.5;">
        <i data-lucide="shield-check" style="width:16px; height:16px; color:var(--cream-muted);"></i>
        <span style="font-size:11px; color:var(--cream-muted); font-weight:500; letter-spacing:0.5px;">100% Pembayaran Aman & Terenkripsi</span>
    </div>

</div>

<script>
    // Fitur Copy VA
    function copyVA() {
        const vaNumber = "8077 0812 3456"; // Sesuaikan dengan variabel dari backend nanti
        navigator.clipboard.writeText(vaNumber.replace(/\s/g, ''));
        
        const btn = document.querySelector('.copy-btn');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i data-lucide="check" style="width:14px; height:14px;"></i> Tersalin!';
        btn.style.background = 'var(--gold)';
        btn.style.color = 'var(--brown-deep)';
        lucide.createIcons();
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.style.background = '';
            btn.style.color = '';
            lucide.createIcons();
        }, 2000);
    }

    // Dummy Countdown Timer (23:59:59)
    let time = 23 * 3600 + 59 * 60 + 59;
    setInterval(() => {
        const hours = Math.floor(time / 3600);
        const minutes = Math.floor((time % 3600) / 60);
        const seconds = time % 60;
        
        document.getElementById('countdown').innerText = 
            `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        time--;
    }, 1000);
</script>
@endsection