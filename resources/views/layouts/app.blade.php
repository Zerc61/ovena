<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ovena — Artisan Bakery') | Ovena</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root{--brown-deep:#1a0e08;--brown-rich:#2c1810;--brown-warm:#3d2015;--maroon:#4a1212;--cream:#f5efe6;--cream-muted:#c8b9a8;--gold:#c9a96e;--gold-light:#e0c992;--gold-dim:rgba(201,169,110,0.12);}
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Inter',sans-serif;background:var(--brown-deep);color:var(--cream);min-height:100vh;overflow-x:hidden;position:relative;}
        h1,h2,h3,h4,h5{font-family:'Playfair Display',serif;}
        ::-webkit-scrollbar{width:6px;}::-webkit-scrollbar-track{background:var(--brown-deep);}::-webkit-scrollbar-thumb{background:var(--brown-warm);border-radius:3px;}
        body::after{content:'';position:fixed;inset:0;z-index:9999;pointer-events:none;opacity:0.025;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");background-size:128px 128px;}
        .cursor-glow{position:fixed;width:500px;height:500px;border-radius:50%;background:radial-gradient(circle,rgba(201,169,110,0.05) 0%,transparent 70%);pointer-events:none;z-index:9998;transform:translate(-50%,-50%);transition:left .4s ease-out,top .4s ease-out;}
        .bg-blob{position:fixed;border-radius:50%;pointer-events:none;filter:blur(140px);z-index:0;}
        .bg-blob-1{width:600px;height:600px;background:rgba(201,169,110,0.03);top:-15%;right:-8%;}
        .bg-blob-2{width:500px;height:500px;background:rgba(74,18,18,0.12);bottom:-15%;left:-8%;}
        .gold-line{height:1px;background:linear-gradient(to right,transparent,rgba(201,169,110,0.25),transparent);}

       /* --- HEADER MINIMALIS --- */
        .site-header {
            position: sticky; top: 0; z-index: 50;
            background: rgba(26, 14, 8, 0.8);
            backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(201, 169, 110, 0.05);
            transition: all 0.3s ease;
        }
        .header-inner {
            display: flex; align-items: center; justify-content: space-between; height: 72px;
        }

        /* Logo */
        .brand-logo {
            display: flex; align-items: center; gap: 10px; text-decoration: none;
        }
        .brand-mark {
            color: var(--gold); font-family: 'Playfair Display', serif; font-size: 22px; font-style: italic; font-weight: 600;
        }
        .brand-text {
            font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500; color: var(--cream); letter-spacing: 2px; text-transform: uppercase;
        }

        /* Navigasi Tengah */
        .desk-nav {
            display: none; align-items: center; gap: 36px;
        }
        @media (min-width: 768px) { .desk-nav { display: flex; } }
        .nav-item {
            font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: 1.5px; color: var(--cream-muted); text-decoration: none; position: relative; padding: 6px 0; transition: color 0.3s;
        }
        .nav-item:hover, .nav-item.active { color: var(--gold); }
        .nav-item::after {
            content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 0; height: 1px; background: var(--gold); transition: width 0.3s ease;
        }
        .nav-item:hover::after, .nav-item.active::after { width: 100%; }

        /* Aksi Kanan & Search */
        .header-actions { display: flex; align-items: center; gap: 20px; }
        
        .minimal-search {
            display: none; align-items: center; border-bottom: 1px solid rgba(201, 169, 110, 0.15); padding-bottom: 4px; width: 140px; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        @media (min-width: 640px) { .minimal-search { display: flex; } }
        .minimal-search:focus-within { border-color: var(--gold); width: 180px; }
        .minimal-search input {
            background: transparent; border: none; outline: none; color: var(--cream); font-size: 12px; width: 100%; padding: 0 8px; font-family: 'Inter', sans-serif;
        }
        .minimal-search input::placeholder { color: rgba(200, 185, 168, 0.3); font-style: italic; text-transform: lowercase; letter-spacing: 0.5px; }

        /* Icon Buttons */
        .hdr-icon {
            color: var(--cream-muted); background: transparent; border: none; cursor: pointer; transition: all 0.3s; position: relative; display: flex; align-items: center; text-decoration: none; padding: 2px;
        }
        .hdr-icon:hover { color: var(--gold); transform: translateY(-1px); }
        .hdr-badge {
            position: absolute; top: -4px; right: -6px; min-width: 16px; height: 16px; border-radius: 50%; background: var(--gold); color: var(--brown-deep); font-size: 9px; font-weight: 700; display: flex; align-items: center; justify-content: center; border: 2px solid var(--brown-deep); padding: 0 4px;
        }
        /* --- END HEADER MINIMALIS --- */

        .cat-card{display:flex;flex-direction:column;align-items:center;gap:8px;padding:16px 10px;border-radius:12px;cursor:pointer;transition:all .3s;border:1px solid transparent;text-decoration:none;}
        .cat-card:hover,.cat-card.active{background:rgba(201,169,110,0.06);border-color:rgba(201,169,110,0.15);}
        .cat-icon-wrap{width:48px;height:48px;border-radius:12px;background:rgba(201,169,110,0.08);display:flex;align-items:center;justify-content:center;transition:all .3s;}
        .cat-card:hover .cat-icon-wrap,.cat-card.active .cat-icon-wrap{background:rgba(201,169,110,0.15);}
        .cat-card.active .cat-label{color:var(--gold);font-weight:600;}

        .p-card{background:rgba(44,24,16,0.45);backdrop-filter:blur(12px);border:1px solid rgba(201,169,110,0.06);border-radius:14px;overflow:hidden;transition:all .35s cubic-bezier(.4,0,.2,1);cursor:pointer;text-decoration:none;color:inherit;display:block;}
        .p-card:hover{transform:translateY(-4px);box-shadow:0 16px 40px rgba(0,0,0,0.25);border-color:rgba(201,169,110,0.15);}
        .p-card .p-img{position:relative;aspect-ratio:1;overflow:hidden;background:rgba(26,14,8,0.8);}
        .p-card .p-img img{width:100%;height:100%;object-fit:cover;transition:transform .6s cubic-bezier(.4,0,.2,1);}
        .p-card:hover .p-img img{transform:scale(1.06);}
        .p-wish{position:absolute;top:8px;right:8px;width:30px;height:30px;border-radius:8px;background:rgba(26,14,8,0.6);backdrop-filter:blur(4px);border:1px solid rgba(201,169,110,0.08);display:flex;align-items:center;justify-content:center;cursor:pointer;opacity:0;transition:all .3s;color:var(--cream-muted);}
        .p-card:hover .p-wish{opacity:1;}
        .p-wish:hover{color:var(--maroon);}
        .p-add{position:absolute;bottom:8px;right:8px;width:34px;height:34px;border-radius:9px;background:var(--gold);color:var(--brown-deep);display:flex;align-items:center;justify-content:center;cursor:pointer;opacity:0;transform:translateY(6px);transition:all .3s;border:none;}
        .p-card:hover .p-add{opacity:1;transform:translateY(0);}
        .p-add:hover{background:var(--gold-light);transform:scale(1.08)!important;}
        .p-stock-out{position:absolute;inset:0;background:rgba(26,14,8,0.7);display:flex;align-items:center;justify-content:center;}
        .p-stock-out span{background:var(--maroon);color:var(--gold-light);padding:4px 14px;border-radius:6px;font-size:11px;font-weight:600;letter-spacing:.5px;text-transform:uppercase;}

        .btn-gold{padding:11px 22px;background:var(--gold);color:var(--brown-deep);border:none;border-radius:10px;font-family:'Inter',sans-serif;font-size:13px;font-weight:600;cursor:pointer;transition:all .3s;display:inline-flex;align-items:center;gap:6px;text-decoration:none;}
        .btn-gold:hover{background:var(--gold-light);transform:translateY(-1px);box-shadow:0 4px 16px rgba(201,169,110,0.2);}
        .btn-outline{padding:11px 22px;background:transparent;color:var(--gold);border:1px solid rgba(201,169,110,0.2);border-radius:10px;font-family:'Inter',sans-serif;font-size:13px;font-weight:500;cursor:pointer;transition:all .3s;display:inline-flex;align-items:center;gap:6px;text-decoration:none;}
        .btn-outline:hover{border-color:var(--gold);background:var(--gold-dim);}
        .btn-sm{padding:8px 16px;font-size:12px;border-radius:8px;}
        .btn-danger{padding:8px 16px;background:rgba(153,27,27,0.2);color:#fca5a5;border:1px solid rgba(153,27,27,0.3);border-radius:8px;font-family:'Inter',sans-serif;font-size:12px;cursor:pointer;transition:all .3s;}
        .btn-danger:hover{background:rgba(153,27,27,0.35);}

        .form-input{width:100%;padding:11px 14px;background:rgba(26,14,8,0.6);border:1px solid rgba(201,169,110,0.1);border-radius:10px;color:var(--cream);font-family:'Inter',sans-serif;font-size:14px;font-weight:300;outline:none;transition:all .3s;}
        .form-input::placeholder{color:rgba(200,185,168,0.25);}
        .form-input:focus{border-color:rgba(201,169,110,0.4);box-shadow:0 0 0 3px rgba(201,169,110,0.06);}
        .form-label{display:block;font-size:11px;letter-spacing:1.5px;text-transform:uppercase;color:var(--cream-muted);margin-bottom:6px;font-weight:500;}
        .form-error{font-size:12px;color:#f87171;margin-top:4px;}

        .toast-wrap{position:fixed;top:80px;right:20px;z-index:300;display:flex;flex-direction:column;gap:8px;}
        .toast{padding:12px 18px;background:rgba(44,24,16,0.95);backdrop-filter:blur(20px);border:1px solid rgba(201,169,110,0.12);border-radius:10px;color:var(--cream);font-size:13px;font-weight:300;display:flex;align-items:center;gap:8px;box-shadow:0 8px 32px rgba(0,0,0,0.35);animation:tIn .4s ease forwards;max-width:340px;}
        .toast.out{animation:tOut .3s ease forwards;}
        @keyframes tIn{from{opacity:0;transform:translateX(24px) scale(.96)}to{opacity:1;transform:translateX(0) scale(1)}}
        @keyframes tOut{from{opacity:1;transform:translateX(0) scale(1)}to{opacity:0;transform:translateX(24px) scale(.96)}}

        .fade-up{opacity:0;transform:translateY(24px);transition:all .65s cubic-bezier(.4,0,.2,1);}
        .fade-up.vis{opacity:1;transform:translateY(0);}

        .status-badge{padding:3px 10px;border-radius:6px;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.3px;}
        .status-pending{background:rgba(201,169,110,0.12);color:var(--gold);}
        .status-dibayar{background:rgba(59,130,246,0.12);color:#60a5fa;}
        .status-diproses{background:rgba(168,85,247,0.12);color:#c084fc;}
        .status-dikirim{background:rgba(37,211,102,0.12);color:#4ade80;}
        .status-selesai{background:rgba(34,197,94,0.12);color:#22c55e;}

        .profile-dropdown{position:absolute;top:calc(100% + 8px);right:0;width:200px;background:rgba(44,24,16,0.95);backdrop-filter:blur(24px);border:1px solid rgba(201,169,110,0.1);border-radius:12px;padding:6px;display:none;z-index:60;box-shadow:0 12px 32px rgba(0,0,0,0.4);}
        .profile-dropdown.open{display:block;}
        .profile-dropdown a,.profile-dropdown button{display:flex;align-items:center;gap:8px;width:100%;padding:9px 12px;border-radius:8px;font-size:13px;color:var(--cream-muted);text-decoration:none;background:none;border:none;cursor:pointer;font-family:'Inter',sans-serif;transition:all .2s;text-align:left;}
        .profile-dropdown a:hover,.profile-dropdown button:hover{background:rgba(201,169,110,0.08);color:var(--cream);}
        .profile-dropdown .divider{height:1px;background:rgba(201,169,110,0.06);margin:4px 0;}

        .pay-opt{display:flex;align-items:center;gap:8px;padding:10px 14px;border-radius:10px;border:1px solid rgba(201,169,110,0.1);background:rgba(26,14,8,0.5);cursor:pointer;transition:all .2s;}
        .pay-opt.selected{border-color:rgba(201,169,110,0.35);background:rgba(201,169,110,0.08);}

        .mobile-fab{display:none;position:fixed;bottom:20px;right:20px;width:52px;height:52px;border-radius:14px;background:var(--gold);color:var(--brown-deep);align-items:center;justify-content:center;z-index:50;box-shadow:0 6px 24px rgba(201,169,110,0.25);cursor:pointer;border:none;transition:transform .3s;}
        .mobile-fab:hover{transform:scale(1.05);}
        @media(max-width:768px){.mobile-fab{display:flex;}.desk-nav{display:none!important;}.p-grid{grid-template-columns:repeat(2,1fr)!important;gap:10px!important;}.cat-grid{grid-template-columns:repeat(4,1fr)!important;gap:4px!important;}}

        @keyframes slideIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    #ovi-messages::-webkit-scrollbar {
        width: 4px;
    }
    #ovi-messages::-webkit-scrollbar-thumb {
        background: rgba(201,169,110,0.2);
        border-radius: 10px;
    }

    @keyframes spin { 100% { transform: rotate(360deg); } }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes scaleUp {
        from { opacity: 0; transform: translate(-50%, -45%) scale(0.95); }
        to { opacity: 1; transform: translate(-50%, -50%) scale(1); }
    }
    </style>
</head>
<body>
    <div class="bg-blob bg-blob-1"></div>
    <div class="bg-blob bg-blob-2"></div>
    <div class="cursor-glow" id="cursorGlow"></div>

    <div id="ovi-container" style="font-family: 'Playfair Display', serif, sans-serif;">
    
    <div id="ovi-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(10, 5, 2, 0.6); backdrop-filter: blur(8px); z-index: 9997; cursor: pointer; animation: fadeIn 0.3s ease;"></div>

    <div id="ovi-window" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 92%; max-width: 500px; height: 85vh; background: #1a0e08; border: 1px solid rgba(201,169,110,0.3); border-radius: 20px; flex-direction: column; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.8); z-index: 9998; animation: scaleUp 0.3s ease;">
        
        <div style="background: linear-gradient(135deg, var(--gold), #a67c00); padding: 20px; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 48px; height: 48px; border-radius: 50%; background: #1a0e08; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
                    <i data-lucide="bot" style="width: 26px; height: 26px; color: var(--gold);"></i>
                </div>
                <div>
                    <h4 style="margin: 0; font-size: 16px; color: #1a0e08; font-weight: 800; font-family: 'Inter', sans-serif;">Ovi - Asisten Ovena</h4>
                    <div style="font-size: 11px; color: rgba(26,14,8,0.8); display: flex; align-items: center; gap: 6px; margin-top: 2px; font-family: 'Inter', sans-serif;">
                        <div style="width: 8px; height: 8px; background: #22c55e; border-radius: 50%; box-shadow: 0 0 6px #22c55e;"></div> Selalu Siap Membantu
                    </div>
                </div>
            </div>
            <button id="ovi-close-header" style="background: rgba(26,14,8,0.1); border: none; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #1a0e08; transition: all 0.2s;">
                <i data-lucide="x" style="width: 20px; height: 20px;"></i>
            </button>
        </div>

        <div id="ovi-messages" style="flex: 1; padding: 24px 20px; overflow-y: auto; display: flex; flex-direction: column; gap: 16px; font-family: 'Inter', sans-serif;">
            <div style="align-self: flex-start; max-width: 85%; background: rgba(201,169,110,0.1); padding: 14px 18px; border-radius: 16px 16px 16px 0; border: 1px solid rgba(201,169,110,0.1);">
                <p style="margin: 0; font-size: 14px; color: var(--cream-muted); line-height: 1.6;">Halo! Saya Ovi. Ada yang bisa saya bantu tentang produk Ovena hari ini? 😊</p>
            </div>
        </div>

        <div style="padding: 16px 20px; border-top: 1px solid rgba(201,169,110,0.15); background: rgba(0,0,0,0.4); font-family: 'Inter', sans-serif;">
            <div style="display: flex; gap: 10px;">
                <input type="text" id="ovi-input" placeholder="Ketik pertanyaan Anda di sini..." style="flex: 1; background: rgba(255,255,255,0.06); border: 1px solid rgba(201,169,110,0.2); border-radius: 12px; padding: 14px 16px; font-size: 14px; color: white; outline: none; transition: all 0.3s;" onfocus="this.style.borderColor='var(--gold)'" onblur="this.style.borderColor='rgba(201,169,110,0.2)'">
                <button id="ovi-send" style="background: var(--gold); border: none; border-radius: 12px; width: 50px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    <i data-lucide="send" style="width: 20px; height: 20px; color: #1a0e08;"></i>
                </button>
            </div>
        </div>
    </div>

    <button id="ovi-toggle" class="btn-gold" style="position: fixed; bottom: 24px; right: 24px; z-index: 9999; width: 64px; height: 64px; border-radius: 50%; box-shadow: 0 10px 30px rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease;">
        <i data-lucide="sparkles" id="ovi-icon-open" style="width: 28px; height: 28px;"></i>
    </button>
</div>

    <!-- Header -->
   <header class="site-header" id="siteHeader">
        <div style="max-width:1200px; margin:0 auto; padding:0 24px;">
            <div class="header-inner">
                
                <a href="/" class="brand-logo">
                       <span style="font-family:'Playfair Display',serif;font-size:25px;color:var(--cream);">OVE<span style="color: #c9a96e">NA</span></span>
                </a>

                <nav class="desk-nav">
                    <a href="/home" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                    <a href="/home?kategori=1" class="nav-item">Roti Klasik</a>
                    <a href="/home?kategori=2" class="nav-item">Pastry</a>
                    <a href="/home?kategori=3" class="nav-item">Kue & Cake</a>
                    <a href="/home?kategori=7" class="nav-item">Paket</a>
                </nav>

                <div class="header-actions">
                    <form action="/home" method="GET" class="minimal-search">
                        <i data-lucide="search" style="width:14px; height:14px; color:rgba(200,185,168,0.5);"></i>
                        <input type="text" name="search" placeholder="cari roti..." value="{{ request('search') }}">
                    </form>

                    @guest
                        <a href="{{ route('login') }}" class="hdr-icon" title="Masuk">
                            <i data-lucide="log-in" style="width:18px; height:18px;"></i>
                        </a>
                    @endguest

                    @auth
                        <a href="{{ route('cart.index') }}" class="hdr-icon" title="Keranjang">
                            <i data-lucide="shopping-bag" style="width:18px; height:18px;"></i>
                            @if(($cartCount ?? 0) > 0)
                                <span class="hdr-badge" id="hCartBadge">{{ $cartCount }}</span>
                            @endif
                        </a>
                        
                        <div style="position:relative;" id="profileWrap">
                            <button class="hdr-icon" title="Profil" onclick="toggleProfile()" style="gap:8px; padding-right:4px;">
                                <i data-lucide="user" style="width:18px; height:18px;"></i>
                                <span style="font-size:12px; font-weight:500; font-family:'Inter', sans-serif; color:var(--cream-muted); max-width:90px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" class="hidden sm:block">
                                    {{ auth()->user()->nama }}
                                </span>
                                <i data-lucide="chevron-down" style="width:12px; height:12px; opacity:0.5;" class="hidden sm:block"></i>
                            </button>
                            
                            <div class="profile-dropdown" id="profileDropdown">
                                <div style="padding:8px 12px 4px; border-bottom:1px solid rgba(201,169,110,0.06); margin-bottom:4px;">
                                    <div style="font-size:13px; font-weight:600; color:var(--cream);">{{ auth()->user()->nama }}</div>
                                    <div style="font-size:11px; color:rgba(200,185,168,0.4);">{{ auth()->user()->email }}</div>
                                </div>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}"><i data-lucide="layout-dashboard" style="width:15px; height:15px;"></i> Admin Panel</a>
                                @endif
                                <a href="{{ route('profile.index') }}"><i data-lucide="user-circle" style="width:15px; height:15px;"></i> Profil Saya</a>
                                <a href="{{ route('orders.index') }}"><i data-lucide="package" style="width:15px; height:15px;"></i> Pesanan Saya</a>
                                <div class="divider"></div>
                                <form method="POST" action="{{ route('logout') }}" style="display:contents;">
                                    @csrf
                                    <button type="submit"><i data-lucide="log-out" style="width:15px; height:15px; color:#ef4444;"></i> <span style="color:#ef4444;">Keluar</span></button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>

            </div>
        </div>
    </header>

    @auth
        @if(auth()->user()->isAdmin())
            <button class="mobile-fab" onclick="window.location='{{ route('admin.dashboard') }}'" style="background:var(--maroon);color:var(--gold-light);" title="Admin">
                <i data-lucide="layout-dashboard" style="width:20px;height:20px;"></i>
            </button>
        @else
            <a href="{{ route('cart.index') }}" class="mobile-fab" title="Keranjang">
                <i data-lucide="shopping-bag" style="width:20px;height:20px;"></i>
                <span class="hdr-badge" style="position:absolute;top:-3px;right:-3px;{{ ($cartCount ?? 0) > 0 ? 'display:flex' : 'display:none' }}">{{ $cartCount ?? 0 }}</span>
            </a>
        @endif
    @else
        <a href="{{ route('login') }}" class="mobile-fab" title="Masuk">
            <i data-lucide="log-in" style="width:20px;height:20px;"></i>
        </a>
    @endauth

    <main style="position:relative;z-index:1;min-height:calc(100vh - 58px);">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer style="position:relative;z-index:1;">
        <div class="gold-line"></div>
        <div style="max-width:1200px;margin:0 auto;display:grid;grid-template-columns:1.4fr 1fr 1fr 1.1fr;gap:36px;padding:36px 20px;">
            <div>
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                    <div style="width:34px;height:34px;border-radius:10px;border:1px solid rgba(201,169,110,0.15);display:flex;align-items:center;justify-content:center;">
                        <span style="color:var(--gold);font-family:'Playfair Display',serif;font-size:16px;font-weight:700;">O</span>
                    </div>
                    <span style="font-family:'Playfair Display',serif;font-size:17px;font-weight:600;color:var(--cream);">Ovena</span>
                </div>
                <p style="font-size:13px;color:rgba(245,239,230,0.35);line-height:1.7;max-width:260px;">Bakery artisan dengan roti berkualitas premium dari bahan terbaik.</p>
            </div>
            <div>
                <h4 style="font-size:12px;font-weight:600;color:var(--gold);margin-bottom:12px;letter-spacing:.5px;">MENU</h4>
                <div style="display:flex;flex-direction:column;gap:6px;">
                    <a href="/home?kategori=1" style="font-size:13px;color:rgba(245,239,230,0.35);text-decoration:none;">Roti Klasik</a>
                    <a href="/home?kategori=2" style="font-size:13px;color:rgba(245,239,230,0.35);text-decoration:none;">Pastry</a>
                    <a href="/home?kategori=3" style="font-size:13px;color:rgba(245,239,230,0.35);text-decoration:none;">Kue & Cake</a>
                    <a href="/home?kategori=5" style="font-size:13px;color:rgba(245,239,230,0.35);text-decoration:none;">Cookies</a>
                    <a href="/home?kategori=7" style="font-size:13px;color:rgba(245,239,230,0.35);text-decoration:none;">Paket</a>
                </div>
            </div>
            <div>
                <h4 style="font-size:12px;font-weight:600;color:var(--gold);margin-bottom:12px;letter-spacing:.5px;">INFO</h4>
                <div style="display:flex;flex-direction:column;gap:6px;">
                    <a href="#" style="font-size:13px;color:rgba(245,239,230,0.35);text-decoration:none;">Tentang Kami</a>
                    <a href="#" style="font-size:13px;color:rgba(245,239,230,0.35);text-decoration:none;">Cara Belanja</a>
                    <a href="#" style="font-size:13px;color:rgba(245,239,230,0.35);text-decoration:none;">Pengiriman</a>
                    <a href="#" style="font-size:13px;color:rgba(245,239,230,0.35);text-decoration:none;">FAQ</a>
                </div>
            </div>
            <div>
                <h4 style="font-size:12px;font-weight:600;color:var(--gold);margin-bottom:12px;letter-spacing:.5px;">KONTAK</h4>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    <span style="font-size:12px;color:rgba(245,239,230,0.35);">Jl. Gandaria Tengah No. 12, Jakarta Selatan</span>
                    <span style="font-size:12px;color:rgba(245,239,230,0.35);">021-7890-1234</span>
                    <span style="font-size:12px;color:rgba(245,239,230,0.35);">hello@ovena.id</span>
                    <span style="font-size:12px;color:rgba(245,239,230,0.35);">06:00 — 21:00 WIB</span>
                </div>
            </div>
        </div>
        <div class="gold-line"></div>
        <div style="max-width:1200px;margin:0 auto;padding:14px 20px;display:flex;justify-content:space-between;">
            <span style="font-size:11px;color:rgba(245,239,230,0.2);">© 2024 Ovena Artisan Bakery</span>
            <span style="font-size:11px;color:rgba(245,239,230,0.2);">Privacy · Terms</span>
        </div>
    </footer>

    <!-- Toasts -->
    <div class="toast-wrap" id="toastWrap">
        @session('success')
            <div class="toast" id="toastFlash">
                <i data-lucide="check-circle" style="width:16px;height:16px;color:#27ae60;flex-shrink:0;"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endsession
        @session('error')
            <div class="toast" id="toastFlash">
                <i data-lucide="alert-circle" style="width:16px;height:16px;color:#c0392b;flex-shrink:0;"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endsession
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('ovi-toggle');
        const chatWindow = document.getElementById('ovi-window');
        const iconOpen = document.getElementById('ovi-icon-open');
        const iconClose = document.getElementById('ovi-icon-close');
        
        // Fitur Buka Tutup
        const overlay = document.getElementById('ovi-overlay');
        const closeHeaderBtn = document.getElementById('ovi-close-header');

        function toggleChat() {
           if (chatWindow.style.display === 'none') {
                chatWindow.style.display = 'flex';
                overlay.style.display = 'block';
                document.body.style.overflow = 'hidden'; // Kunci scroll halaman belakang
            } else {
                chatWindow.style.display = 'none';
                overlay.style.display = 'none';
                document.body.style.overflow = 'auto'; // Buka kunci scroll
            }
            lucide.createIcons();
        }

        // Event listener untuk buka tutup
        toggleBtn.addEventListener('click', toggleChat);
        closeHeaderBtn.addEventListener('click', toggleChat);
        overlay.addEventListener('click', toggleChat); // Klik area gelap untuk menutup chat

        // Fitur Kirim Pesan ke AI
        const sendBtn = document.getElementById('ovi-send');
        const inputField = document.getElementById('ovi-input');
        const messagesArea = document.getElementById('ovi-messages');

        function sendMessage() {
            const text = inputField.value.trim();
            if(!text) return;

            // 1. Tampilkan pesan user ke layar
            appendMessage('user', text);
            inputField.value = '';

            // 2. Tampilkan indikator "Ovi sedang mengetik..."
            const typingId = 'typing-' + Date.now();
            appendMessage('bot', '<i data-lucide="loader-2" class="spin" style="width:14px;height:14px;animation: spin 1s linear infinite;"></i> Mengetik...', typingId);
            lucide.createIcons();

            // 3. Kirim ke Backend Laravel
            fetch('{{ route('chatbot.send') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: text })
            })
            .then(response => response.json())
            .then(data => {
                // Hapus indikator mengetik
                document.getElementById(typingId).remove();
                
                // Tampilkan balasan AI
                if(data.status === 'success') {
                    appendMessage('bot', data.reply);
                } else {
                    appendMessage('bot', 'Aduh, koneksi Ovi terputus.');
                }
            })
            .catch(error => {
                document.getElementById(typingId).remove();
                appendMessage('bot', 'Maaf, terjadi kesalahan jaringan.');
            });
        }

        // Fungsi membuat kotak pesan (VERSI PINTAR DENGAN KARTU PRODUK)
        function appendMessage(sender, text, id = '') {
            const div = document.createElement('div');
            div.id = id;
            div.className = 'message-bubble';
            div.style.maxWidth = '80%';
            div.style.padding = '10px 14px';
            div.style.fontSize = '13px';
            div.style.lineHeight = '1.5';
            div.style.marginBottom = '10px';
            
            if (sender === 'user') {
                div.style.alignSelf = 'flex-end';
                div.style.background = 'var(--gold)';
                div.style.color = '#1a0e08';
                div.style.borderRadius = '12px 12px 0 12px';
                div.style.fontWeight = '500';
            } else {
                div.style.alignSelf = 'flex-start';
                div.style.background = 'rgba(201,169,110,0.1)';
                div.style.color = 'var(--cream-muted)';
                div.style.borderRadius = '12px 12px 12px 0';
                div.style.border = '1px solid rgba(201,169,110,0.05)';
            }

            // --- LOGIKA PARSING PRODUK ---
            const productMatch = text.match(/\[PRODUK-(\d+)\]/);
            
            // Bersihkan teks asli dari kode rahasia agar tidak terlihat user
            let cleanText = text.replace(/\[PRODUK-\d+\]/g, '');

            // --- ✨ SIHIR MERAPIKAN TEKS (MARKDOWN PARSER) ✨ ---
            // 1. Ubah **teks** menjadi Huruf Tebal (Bold)
            cleanText = cleanText.replace(/\*\*(.*?)\*\*/g, '<strong style="color: var(--gold);">$1</strong>');
            
            // 2. Ubah *teks* menjadi Huruf Miring (Italic)
            cleanText = cleanText.replace(/\*(.*?)\*/g, '<em>$1</em>');
            
            // 3. Ubah Enter/Baris Baru menjadi tag <br> agar tidak numpuk
            cleanText = cleanText.replace(/\n/g, '<br>');
            div.innerHTML = cleanText;

            messagesArea.appendChild(div);

            // Jika ditemukan kode produk, tembak API untuk ambil kartunya
            if (sender === 'bot' && productMatch) {
                const productId = productMatch[1];
                fetch(`/chatbot/product/${productId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.html) {
                            div.innerHTML += data.html; // Tempel kartu di bawah teks
                            messagesArea.scrollTop = messagesArea.scrollHeight;
                        }
                    });
            }
            
            messagesArea.scrollTop = messagesArea.scrollHeight;
        }

        // Event listener tombol send & enter
        sendBtn.addEventListener('click', sendMessage);
        inputField.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') sendMessage();
        });
    });

    // ==========================================
    // KODE LAINNYA DI LUAR CHATBOT
    // ==========================================
    document.addEventListener('mousemove', e => {
        const g = document.getElementById('cursorGlow');
        if(g) { g.style.left = e.clientX + 'px'; g.style.top = e.clientY + 'px'; }
    });
    
    function toggleProfile(){
        const dd = document.getElementById('profileDropdown');
        if(dd) dd.classList.toggle('open');
    }
    
    document.addEventListener('click', e => {
        const w = document.getElementById('profileWrap');
        const dd = document.getElementById('profileDropdown');
        if(w && !w.contains(e.target) && dd){
            dd.classList.remove('open');
        }
    });
    
    const fadeObs = new IntersectionObserver(e => {
        e.forEach(x => {
            if(x.isIntersecting){
                x.target.classList.add('vis');
                fadeObs.unobserve(x.target);
            }
        });
    },{threshold:.08});
    document.querySelectorAll('.fade-up:not(.vis)').forEach(x => fadeObs.observe(x));
    
    document.querySelectorAll('.toast#toastFlash').forEach(t => {
        setTimeout(() => {
            t.classList.add('out');
            setTimeout(() => t.remove(), 300);
        }, 3500);
    });
    
    lucide.createIcons();
</script>
    @stack('scripts')
</body>
</html>