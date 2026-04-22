@extends('layouts.app')
@section('content')
<div style="max-width:1200px;margin:0 auto;padding:20px 20px 0;">


    {{-- Hero / Banner Slider Section --}}
    @if(isset($banners) && $banners->isNotEmpty())
    <section style="margin-bottom:40px; position:relative; border-radius:20px; overflow:hidden; background:var(--brown-rich); box-shadow:0 10px 30px rgba(0,0,0,0.3);">
        
        {{-- Track Slider --}}
        <div id="bannerTrack" style="display:flex; transition:transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);">
            @foreach($banners as $b)
            <div class="banner-slide" style="min-width:100%; display:grid; grid-template-columns:1fr 1fr; align-items:center; padding:50px 60px; position:relative;">
                
                {{-- Efek Glow Halus di Background --}}
                <div style="position:absolute; top:50%; right:20%; width:300px; height:300px; background:var(--gold); filter:blur(100px); opacity:0.1; border-radius:50%; z-index:0;"></div>

                {{-- Kiri: Teks --}}
                <div style="z-index:2; padding-right:20px;">
                    <h1 style="font-size:42px; font-weight:400; color:var(--cream); line-height:1.2; margin-bottom:16px; font-family:'Playfair Display', serif;">
                        {!! nl2br(e($b->judul)) !!}
                    </h1>
                    @if($b->subjudul)
                    <p style="font-size:14px; color:var(--cream-muted); margin-bottom:32px; line-height:1.7; max-width:90%; font-weight:300;">
                        {{ $b->subjudul }}
                    </p>
                    @endif

                   {{-- Tombol link ke produk spesifik atau ke bagian bawah --}}
                    @php 
                        $link = $b->product_id ? route('products.show', $b->product_id) : '#semua-produk'; 
                    @endphp
                    <a href="{{ $link }}" class="btn-gold" style="padding:12px 28px; font-size:13px; text-transform:uppercase; letter-spacing:1px; display:inline-flex; margin-top:8px;">
            Pesan Sekarang <i data-lucide="arrow-right" style="width:16px;height:16px;"></i>
        </a>
                </div>

                {{-- Kanan: Gambar Makanan (Isolated/Cutout Style) --}}
                <div style="z-index:2; display:flex; justify-content:flex-end; align-items:center;">
                    <img src="{{ asset('storage/' . $b->gambar_url) }}" alt="{{ $b->judul }}" style="max-width:100%; height:auto; max-height:280px; object-fit:contain; filter:drop-shadow(0 20px 25px rgba(0,0,0,0.5)); transform:scale(1.05);">
                </div>
            </div>
            @endforeach
        </div>

        {{-- Navigasi Slider (Hanya muncul jika banner lebih dari 1) --}}
        @if($banners->count() > 1)
        <button onclick="moveSlide(-1)" style="position:absolute; left:20px; top:50%; transform:translateY(-50%); background:rgba(26,14,8,0.4); color:var(--gold); border:1px solid rgba(201,169,110,0.2); width:40px; height:40px; border-radius:50%; cursor:pointer; display:flex; align-items:center; justify-content:center; z-index:10; backdrop-filter:blur(4px); transition:all 0.2s;" onmouseover="this.style.background='var(--gold)'; this.style.color='var(--brown-deep)';" onmouseout="this.style.background='rgba(26,14,8,0.4)'; this.style.color='var(--gold)';">
            <i data-lucide="chevron-left" style="width:20px;height:20px;"></i>
        </button>
        <button onclick="moveSlide(1)" style="position:absolute; right:20px; top:50%; transform:translateY(-50%); background:rgba(26,14,8,0.4); color:var(--gold); border:1px solid rgba(201,169,110,0.2); width:40px; height:40px; border-radius:50%; cursor:pointer; display:flex; align-items:center; justify-content:center; z-index:10; backdrop-filter:blur(4px); transition:all 0.2s;" onmouseover="this.style.background='var(--gold)'; this.style.color='var(--brown-deep)';" onmouseout="this.style.background='rgba(26,14,8,0.4)'; this.style.color='var(--gold)';">
            <i data-lucide="chevron-right" style="width:20px;height:20px;"></i>
        </button>

        <div style="position:absolute; bottom:20px; left:60px; display:flex; gap:8px; z-index:10;">
            @foreach($banners as $index => $b)
            <button onclick="goToSlide({{ $index }})" class="banner-dot" data-index="{{ $index }}" style="width:8px; height:8px; border-radius:50%; background:{{ $index == 0 ? 'var(--gold)' : 'rgba(201,169,110,0.3)' }}; border:none; cursor:pointer; transition:all 0.3s; padding:0;"></button>
            @endforeach
        </div>
        @endif
    </section>
    @endif


    {{-- Voucher Spesial Section --}}
    @if(isset($vouchers) && $vouchers->isNotEmpty())
    <section style="margin-bottom:40px;" class="fade-up">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
            <div style="width:40px;height:3px;background:var(--gold);border-radius:2px;"></div>
            <h2 style="font-size:20px;font-weight:600;color:var(--cream);">Voucher Spesial</h2>
        </div>
        
        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(300px, 1fr));gap:16px;">
            @foreach($vouchers as $v)
            <div style="background:rgba(201,169,110,0.06); border:1px dashed rgba(201,169,110,0.3); border-radius:14px; padding:20px; position:relative; overflow:hidden; display:flex; flex-direction:column; justify-content:space-between; transition:all 0.3s;" onmouseover="this.style.background='rgba(201,169,110,0.1)'; this.style.borderColor='var(--gold)';" onmouseout="this.style.background='rgba(201,169,110,0.06)'; this.style.borderColor='rgba(201,169,110,0.3)';">
                
                {{-- Efek Sobekan Tiket di Kiri & Kanan --}}
                <div style="position:absolute; top:50%; left:-10px; transform:translateY(-50%); width:20px; height:20px; background:var(--brown-deep); border-radius:50%; border-right:1px dashed rgba(201,169,110,0.3);"></div>
                <div style="position:absolute; top:50%; right:-10px; transform:translateY(-50%); width:20px; height:20px; background:var(--brown-deep); border-radius:50%; border-left:1px dashed rgba(201,169,110,0.3);"></div>

                <div style="margin-bottom:16px; padding:0 12px;">
                    <div style="font-size:11px; color:var(--cream-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:6px; display:flex; align-items:center; gap:6px;">
                        <i data-lucide="ticket" style="width:14px;height:14px;color:var(--gold);"></i> Diskon Promo
                    </div>
                    <div style="font-size:28px; font-weight:700; color:var(--gold); font-family:'Playfair Display', serif; margin-bottom:4px; line-height:1;">
                        {{ $v->tipe === 'persen' ? $v->nilai . '%' : 'Rp ' . number_format($v->nilai, 0, '.', '.') }}
                    </div>
                    <div style="font-size:12px; color:var(--cream-muted); opacity:0.8;">
                        Min. belanja Rp {{ number_format($v->min_belanja, 0, '.', '.') }}
                    </div>
                </div>

                <div style="border-top:1px dashed rgba(201,169,110,0.2); padding:16px 12px 0; display:flex; align-items:center; justify-content:space-between;">
                    <div style="font-family:monospace; font-weight:700; color:var(--cream); background:rgba(0,0,0,0.3); padding:6px 12px; border-radius:6px; font-size:14px; letter-spacing:1px; border:1px solid rgba(201,169,110,0.1);">
                        {{ $v->kode_voucher }}
                    </div>
                    <button onclick="copyVoucher('{{ $v->kode_voucher }}', this)" style="background:none; border:none; color:var(--gold); font-size:12px; font-weight:600; cursor:pointer; text-transform:uppercase; transition:all 0.2s; display:flex; align-items:center; gap:4px;">
                        <i data-lucide="copy" style="width:14px;height:14px;"></i> <span>Salin</span>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

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

@push('scripts')
<script>
    // --- Logic Slider Banner ---
    let currentSlide = 0;
    const totalSlides = {{ isset($banners) ? $banners->count() : 0 }};
    let slideInterval;

    function updateSlide() {
        if(totalSlides <= 1) return;
        const track = document.getElementById('bannerTrack');
        track.style.transform = `translateX(-${currentSlide * 100}%)`;
        
        // Update warna titik navigasi (dots)
        document.querySelectorAll('.banner-dot').forEach((dot, idx) => {
            dot.style.background = idx === currentSlide ? 'var(--gold)' : 'rgba(201,169,110,0.3)';
            dot.style.transform = idx === currentSlide ? 'scale(1.3)' : 'scale(1)';
        });
    }

    function moveSlide(direction) {
        currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
        updateSlide();
        resetInterval();
    }

    function goToSlide(index) {
        currentSlide = index;
        updateSlide();
        resetInterval();
    }

    function startInterval() {
        if(totalSlides > 1) {
            // Pindah slide tiap 3000ms (3 detik)
            slideInterval = setInterval(() => moveSlide(1), 3000);
        }
    }

    function resetInterval() {
        clearInterval(slideInterval);
        startInterval();
    }

    function copyVoucher(kode, btnElement) {
        // Salin ke clipboard
        navigator.clipboard.writeText(kode).then(() => {
            // Ubah teks dan warna tombol sementara untuk memberi tahu user bahwa sudah tersalin
            const originalHTML = btnElement.innerHTML;
            btnElement.innerHTML = '<i data-lucide="check" style="width:14px;height:14px;"></i> Disalin!';
            btnElement.style.color = '#4ade80'; // Ubah warna jadi hijau
            
            lucide.createIcons(); // Render ulang ikon lucide

            // Kembalikan tombol seperti semula setelah 2 detik
            setTimeout(() => {
                btnElement.innerHTML = originalHTML;
                btnElement.style.color = 'var(--gold)';
                lucide.createIcons();
            }, 2000);
        }).catch(err => {
            alert('Gagal menyalin kode!');
        });
    }

    // Mulai slider saat halaman dimuat
    document.addEventListener('DOMContentLoaded', startInterval);
</script>
@endpush
@endsection

