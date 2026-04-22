@extends('layouts.app')
@section('content')
<div style="max-width:900px;margin:0 auto;padding:28px 20px 40px;">
    <a href="/" style="display:inline-flex;align-items:center;gap:4px;font-size:13px;color:var(--cream-muted);text-decoration:none;margin-bottom:24px;opacity:.5;"><i data-lucide="arrow-left" style="width:14px;height:14px;"></i> Kembali</a>
    
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:36px;margin-bottom:48px;" class="fade-up">
        <div style="border-radius:16px;overflow:hidden;aspect-ratio:1;background:rgba(26,14,8,0.8);">
            <img src="{{ $product->image_url ?: 'https://picsum.photos/seed/detail'.$product->id.'/600/600.jpg' }}" alt="{{ $product->nama_produk }}" style="width:100%;height:100%;object-fit:cover;">
        </div>
        <div>
            @if($product->category)
            <span style="font-size:11px;color:var(--gold);text-transform:uppercase;letter-spacing:1px;font-weight:500;">{{ $product->category->nama_kategori }}</span>
            @endif
            
            <h1 style="font-size:28px;font-weight:600;color:var(--cream);margin:8px 0 8px;line-height:1.2;">{{ $product->nama_produk }}</h1>
            
            {{-- Rating Summary di bawah Judul --}}
            @php 
                $avgRating = $product->reviews->avg('rating') ?: 0; 
                $totalReviews = $product->reviews->count();
            @endphp
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px;">
                <div style="display:flex;gap:2px;color:var(--gold);">
                    @for($i=1; $i<=5; $i++)
                        <i data-lucide="star" style="width:14px;height:14px; {{ $i <= round($avgRating) ? 'fill:var(--gold);' : 'opacity:0.3;' }}"></i>
                    @endfor
                </div>
                <span style="font-size:12px;color:var(--cream-muted);">{{ number_format($avgRating, 1) }} ({{ $totalReviews }} Ulasan)</span>
            </div>

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

    {{-- ============================================ --}}
    {{-- Section Ulasan & Testimoni — Redesigned --}}
    {{-- ============================================ --}}
    <section class="fade-up" style="margin-bottom:64px;border-top:1px solid rgba(201,169,110,0.06);padding-top:44px;">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:36px;">
            <div style="width:40px;height:3px;background:var(--gold);border-radius:2px;"></div>
            <h2 style="font-size:22px;font-weight:700;color:var(--cream);letter-spacing:-0.02em;">Ulasan Pelanggan</h2>
        </div>

        {{-- Rating Distribution Overview --}}
        @if(!$product->reviews->isEmpty())
        <div style="background:linear-gradient(135deg, rgba(201,169,110,0.07) 0%, rgba(44,24,16,0.5) 100%);border:1px solid rgba(201,169,110,0.09);border-radius:18px;padding:28px 32px;margin-bottom:36px;display:flex;align-items:center;gap:40px;flex-wrap:wrap;">
            <div style="text-align:center;min-width:100px;">
                <div style="font-size:48px;font-weight:800;color:var(--gold);line-height:1;letter-spacing:-0.03em;">{{ number_format($avgRating, 1) }}</div>
                <div style="display:flex;gap:3px;justify-content:center;margin-top:8px;">
                    @for($i = 1; $i <= 5; $i++)
                        <svg width="16" height="16" viewBox="0 0 24 24" style="{{ $i <= round($avgRating) ? 'fill:var(--gold);' : 'fill:rgba(201,169,110,0.18);' }}">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    @endfor
                </div>
                <div style="font-size:11px;color:var(--cream-muted);margin-top:6px;opacity:0.5;">{{ $totalReviews }} ulasan</div>
            </div>
            <div style="flex:1;min-width:200px;display:flex;flex-direction:column;gap:6px;">
                @for($star = 5; $star >= 1; $star--)
                    @php $count = $product->reviews->where('rating', $star)->count(); @endphp
                    @php $pct = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0; @endphp
                    <div style="display:flex;align-items:center;gap:10px;">
                        <span style="font-size:12px;color:var(--cream-muted);min-width:14px;text-align:right;">{{ $star }}</span>
                        <svg width="13" height="13" viewBox="0 0 24 24" style="fill:var(--gold);flex-shrink:0;">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <div style="flex:1;height:6px;background:rgba(201,169,110,0.06);border-radius:3px;overflow:hidden;">
                            <div style="height:100%;width:{{ $pct }}%;background:linear-gradient(90deg, var(--gold), rgba(201,169,110,0.65));border-radius:3px;transition:width 0.8s cubic-bezier(0.16,1,0.3,1);"></div>
                        </div>
                        <span style="font-size:11px;color:var(--cream-muted);opacity:0.4;min-width:20px;">{{ $count }}</span>
                    </div>
                @endfor
            </div>
        </div>
        @endif

        {{-- Two-column: Form + Reviews List --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:40px;">
            {{-- LEFT: Form Tambah Ulasan --}}
            <div>
                @auth
                    <div style="background:rgba(44,24,16,0.4);border:1px solid rgba(201,169,110,0.07);border-radius:18px;padding:28px;position:relative;overflow:hidden;">
                        {{-- Decorative glow --}}
                        <div style="position:absolute;top:-60px;right:-60px;width:130px;height:130px;background:radial-gradient(circle, rgba(201,169,110,0.06) 0%, transparent 70%);pointer-events:none;"></div>

                        <h3 style="font-size:15px;font-weight:700;color:var(--cream);margin-bottom:4px;letter-spacing:-0.01em;">Berikan Ulasanmu</h3>
                        <p style="font-size:12px;color:var(--cream-muted);opacity:0.45;margin-bottom:22px;">Bagikan pengalamanmu untuk membantu pembeli lain</p>

                        <form method="POST" action="{{ route('reviews.store', $product) }}" id="reviewForm">
                            @csrf

                            {{-- Interactive Star Picker --}}
                            <div style="margin-bottom:20px;">
                                <label class="form-label" style="margin-bottom:10px;display:block;">Penilaian</label>
                                <div style="display:flex;gap:6px;align-items:center;" id="starPicker">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button" onclick="setRating({{ $i }})" data-star="{{ $i }}" style="background:none;border:none;cursor:pointer;padding:4px;transition:transform 0.2s ease;" onmouseenter="hoverRating({{ $i }})" onmouseleave="resetRatingHover()">
                                            <svg width="28" height="28" viewBox="0 0 24 24" class="star-icon" data-star="{{ $i }}" style="fill:rgba(201,169,110,0.13);transition:fill 0.2s ease, transform 0.2s ease;">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                            </svg>
                                        </button>
                                    @endfor
                                    <input type="hidden" name="rating" id="ratingInput" value="">
                                    <span id="ratingLabel" style="font-size:12px;color:var(--cream-muted);opacity:0;align-self:center;margin-left:8px;transition:opacity 0.3s;"></span>
                                </div>
                            </div>

                            {{-- Komentar --}}
                            <div style="margin-bottom:22px;position:relative;">
                                <label class="form-label" style="margin-bottom:8px;display:block;">Komentar</label>
                                <textarea name="komentar" id="reviewText" class="form-input" rows="4" placeholder="Ceritakan pengalamanmu dengan produk ini..." required style="resize:none;background:rgba(0,0,0,0.25);border:1px solid rgba(201,169,110,0.08);border-radius:12px;padding:14px 16px;font-size:13px;color:var(--cream);width:100%;transition:border-color 0.3s ease, box-shadow 0.3s ease;line-height:1.6;" onfocus="this.style.borderColor='rgba(201,169,110,0.25)';this.style.boxShadow='0 0 0 3px rgba(201,169,110,0.06)'" onblur="this.style.borderColor='rgba(201,169,110,0.08)';this.style.boxShadow='none'"></textarea>
                                <div style="text-align:right;margin-top:6px;">
                                    <span id="charCount" style="font-size:10px;color:var(--cream-muted);opacity:0.3;">0 / 500</span>
                                </div>
                            </div>

                            {{-- Submit --}}
                            <button type="submit" id="submitBtn" class="btn-gold" style="width:100%;padding:13px;border-radius:12px;font-size:14px;font-weight:600;letter-spacing:0.01em;transition:all 0.3s ease;" onmouseenter="this.style.boxShadow='0 8px 30px rgba(201,169,110,0.25)'" onmouseleave="this.style.boxShadow='none'">
                                Kirim Ulasan
                            </button>
                        </form>
                    </div>
                @else
                    <div style="background:rgba(44,24,16,0.35);border:1px dashed rgba(201,169,110,0.1);border-radius:18px;padding:44px 28px;text-align:center;position:relative;overflow:hidden;">
                        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:140px;height:140px;background:radial-gradient(circle, rgba(201,169,110,0.04) 0%, transparent 70%);pointer-events:none;"></div>
                        <div style="width:52px;height:52px;border-radius:14px;background:rgba(201,169,110,0.06);border:1px solid rgba(201,169,110,0.1);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                            <i data-lucide="lock" style="width:22px;height:22px;color:var(--gold);opacity:0.7;"></i>
                        </div>
                        <p style="font-size:14px;color:var(--cream);margin-bottom:6px;font-weight:500;">Login untuk Memberikan Ulasan</p>
                        <p style="font-size:12px;color:var(--cream-muted);opacity:0.4;margin-bottom:22px;line-height:1.5;">Bergabunglah dan bagikan pengalamanmu<br>kepada pembeli lainnya</p>
                        <a href="{{ route('login') }}" class="btn-outline" style="display:inline-block;padding:11px 32px;border-radius:12px;font-size:13px;font-weight:600;text-decoration:none;transition:all 0.3s ease;" onmouseenter="this.style.background='rgba(201,169,110,0.08)'" onmouseleave="this.style.background='transparent'">Login Sekarang</a>
                    </div>
                @endauth
            </div>

            {{-- RIGHT: Daftar Ulasan --}}
            <div>
                @if($product->reviews->isEmpty())
                    <div style="text-align:center;padding:60px 20px;">
                        <div style="width:56px;height:56px;border-radius:50%;background:rgba(201,169,110,0.04);border:1px solid rgba(201,169,110,0.06);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                            <i data-lucide="message-circle" style="width:24px;height:24px;color:var(--gold);opacity:0.25;"></i>
                        </div>
                        <p style="font-size:14px;color:var(--cream);opacity:0.35;font-weight:500;margin-bottom:4px;">Belum Ada Ulasan</p>
                        <p style="font-size:12px;color:var(--cream-muted);opacity:0.25;">Jadilah yang pertama memberikan ulasan</p>
                    </div>
                @else
                    <div style="display:flex;flex-direction:column;gap:0;max-height:460px;overflow-y:auto;padding-right:8px;" id="reviewList">
                        <style>
                            #reviewList::-webkit-scrollbar{width:4px}
                            #reviewList::-webkit-scrollbar-track{background:rgba(201,169,110,0.02);border-radius:2px}
                            #reviewList::-webkit-scrollbar-thumb{background:rgba(201,169,110,0.12);border-radius:2px}
                            #reviewList::-webkit-scrollbar-thumb:hover{background:rgba(201,169,110,0.22)}
                            .rv-card{padding:16px 14px;border-bottom:1px solid rgba(201,169,110,0.04);border-radius:12px;margin:0 -14px;transition:background 0.3s ease}
                            .rv-card:last-child{border-bottom:none}
                            .rv-card:hover{background:rgba(201,169,110,0.03)}
                        </style>
                        @foreach($product->reviews as $review)
                            <div class="rv-card">
                                <div style="display:flex;gap:12px;">
                                    {{-- Avatar Initial --}}
                                    <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg, rgba(201,169,110,0.14), rgba(201,169,110,0.04));border:1px solid rgba(201,169,110,0.09);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <span style="font-size:13px;font-weight:700;color:var(--gold);text-transform:uppercase;">{{ substr($review->user->nama, 0, 1) }}</span>
                                    </div>
                                    <div style="flex:1;min-width:0;">
                                        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:6px;">
                                            <div>
                                                <div style="font-size:13px;font-weight:600;color:var(--cream);">{{ $review->user->nama }}</div>
                                                <div style="font-size:10px;color:var(--cream-muted);opacity:0.35;margin-top:2px;">{{ $review->created_at->diffForHumans() }}</div>
                                            </div>
                                            <div style="display:flex;gap:2px;flex-shrink:0;">
                                                @for($i=1; $i<=5; $i++)
                                                    <svg width="12" height="12" viewBox="0 0 24 24" style="{{ $i <= $review->rating ? 'fill:var(--gold);' : 'fill:rgba(201,169,110,0.1);' }}">
                                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                        </div>
                                        <p style="font-size:13px;color:var(--cream-muted);line-height:1.65;margin:0;">{{ $review->komentar }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ============================================ --}}
    {{-- Produk Serupa — Redesigned --}}
    {{-- ============================================ --}}
    @if($related->isNotEmpty())
    <section class="fade-up" style="margin-top:8px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:40px;height:3px;background:var(--gold);border-radius:2px;"></div>
                <h2 style="font-size:22px;font-weight:700;color:var(--cream);letter-spacing:-0.02em;">Produk Serupa</h2>
            </div>
            <a href="{{ route('home') }}" style="font-size:12px;color:var(--gold);opacity:0.5;text-decoration:none;transition:opacity 0.3s;" onmouseenter="this.style.opacity='1'" onmouseleave="this.style.opacity='0.5'">
                Lihat Semua →
            </a>
        </div>
        <style>
            .rel-card{text-decoration:none;display:block;border-radius:16px;overflow:hidden;background:rgba(44,24,16,0.28);border:1px solid rgba(201,169,110,0.05);transition:all 0.4s cubic-bezier(0.16,1,0.3,1)}
            .rel-card:hover{border-color:rgba(201,169,110,0.14);transform:translateY(-4px);box-shadow:0 16px 48px rgba(0,0,0,0.3)}
            .rel-card .rel-img{position:relative;overflow:hidden;aspect-ratio:1;background:rgba(0,0,0,0.2)}
            .rel-card .rel-img img{width:100%;height:100%;object-fit:cover;transition:transform 0.6s cubic-bezier(0.16,1,0.3,1)}
            .rel-card:hover .rel-img img{transform:scale(1.06)}
            .rel-card .rel-img::after{content:'';position:absolute;inset:0;background:linear-gradient(to top, rgba(10,6,4,0.35) 0%, transparent 50%);pointer-events:none}
        </style>
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
            @foreach($related as $r)
            <a href="{{ route('products.show', $r) }}" class="rel-card fade-up">
                <div class="rel-img"><img src="{{ $r->image_url ?: 'https://picsum.photos/seed/rel'.$r->id.'/400/400.jpg' }}" loading="lazy"></div>
                <div style="padding:14px 16px 16px;">
                    <h4 style="font-size:13px;font-weight:500;color:var(--cream);margin-bottom:6px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $r->nama_produk }}</h4>
                    <span style="font-size:15px;font-weight:700;color:var(--gold);letter-spacing:-0.01em;">{{ number_format($r->harga,0,'.','.') }}</span>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif
</div>

{{-- Review Form Interactive Scripts --}}
<script>
    let currentRating = 0;
    const ratingLabels = {1:'Sangat Kurang',2:'Kurang',3:'Cukup',4:'Bagus',5:'Sangat Bagus'};

    function setRating(val){
        currentRating=val;
        document.getElementById('ratingInput').value=val;
        const lbl=document.getElementById('ratingLabel');
        lbl.textContent=ratingLabels[val];
        lbl.style.opacity='0.65';
        updateStars(val);
    }
    function hoverRating(val){updateStars(val)}
    function resetRatingHover(){updateStars(currentRating)}
    function updateStars(activeVal){
        document.querySelectorAll('.star-icon').forEach(s=>{
            const n=parseInt(s.dataset.star);
            s.style.fill=n<=activeVal?'var(--gold)':'rgba(201,169,110,0.13)';
            s.style.transform=n<=activeVal?'scale(1.15)':'scale(1)';
        });
    }

    const reviewText=document.getElementById('reviewText');
    const charCount=document.getElementById('charCount');
    if(reviewText&&charCount){
        reviewText.addEventListener('input',function(){
            const len=this.value.length;
            if(len>500)this.value=this.value.substring(0,500);
            charCount.textContent=Math.min(len,500)+' / 500';
            charCount.style.opacity=len>450?'0.65':'0.3';
            charCount.style.color=len>480?'rgba(255,100,100,0.8)':'';
        });
    }

    const reviewForm=document.getElementById('reviewForm');
    if(reviewForm){
        reviewForm.addEventListener('submit',function(e){
            if(!currentRating){
                e.preventDefault();
                const pk=document.getElementById('starPicker');
                pk.style.animation='shake 0.4s ease';
                setTimeout(()=>pk.style.animation='',400);
                return false;
            }
        });
    }

    const shakeStyle=document.createElement('style');
    shakeStyle.textContent='@keyframes shake{0%,100%{transform:translateX(0)}20%{transform:translateX(-6px)}40%{transform:translateX(6px)}60%{transform:translateX(-4px)}80%{transform:translateX(4px)}}';
    document.head.appendChild(shakeStyle);
</script>
@endsection