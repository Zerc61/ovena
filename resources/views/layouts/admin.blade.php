<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') | Ovena</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root{--brown-deep:#1a0e08;--brown-rich:#2c1810;--brown-warm:#3d2015;--maroon:#4a1212;--cream:#f5efe6;--cream-muted:#c8b9a8;--gold:#c9a96e;--gold-light:#e0c992;--gold-dim:rgba(201,169,110,0.12);}
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Inter',sans-serif;background:var(--brown-deep);color:var(--cream);min-height:100vh;}
        h1,h2,h3,h4,h5{font-family:'Playfair Display',serif;}
        ::-webkit-scrollbar{width:5px;}::-webkit-scrollbar-track{background:var(--brown-deep);}::-webkit-scrollbar-thumb{background:var(--brown-warm);border-radius:3px;}

        .admin-header{background:rgba(26,14,8,0.95);backdrop-filter:blur(24px);border-bottom:1px solid rgba(201,169,110,0.06);position:sticky;top:0;z-index:50;}
        .admin-nav{display:flex;gap:4px;padding:0 20px;height:44px;align-items:center;border-top:1px solid rgba(201,169,110,0.04);}
        .admin-nav a{font-size:12px;color:var(--cream-muted);text-decoration:none;padding:6px 14px;border-radius:6px;transition:all .2s;font-weight:500;}
        .admin-nav a:hover,.admin-nav a.active{color:var(--gold);background:rgba(201,169,110,0.06);}

        .form-input{width:100%;padding:10px 14px;background:rgba(26,14,8,0.6);border:1px solid rgba(201,169,110,0.1);border-radius:10px;color:var(--cream);font-family:'Inter',sans-serif;font-size:13px;outline:none;transition:all .3s;}
        .form-input::placeholder{color:rgba(200,185,168,0.25);}
        .form-input:focus{border-color:rgba(201,169,110,0.4);box-shadow:0 0 0 3px rgba(201,169,110,0.06);}
        select.form-input{cursor:pointer;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23c8b9a8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center;}
        textarea.form-input{resize:vertical;font-family:'Inter',sans-serif;min-height:60px;}
        .form-label{display:block;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--cream-muted);margin-bottom:5px;font-weight:500;}

        .btn-gold{padding:9px 18px;background:var(--gold);color:var(--brown-deep);border:none;border-radius:8px;font-family:'Inter',sans-serif;font-size:12px;font-weight:600;cursor:pointer;transition:all .3s;display:inline-flex;align-items:center;gap:5px;text-decoration:none;}
        .btn-gold:hover{background:var(--gold-light);}
        .btn-outline{padding:9px 18px;background:transparent;color:var(--gold);border:1px solid rgba(201,169,110,0.2);border-radius:8px;font-family:'Inter',sans-serif;font-size:12px;font-weight:500;cursor:pointer;transition:all .3s;display:inline-flex;align-items:center;gap:5px;text-decoration:none;}
        .btn-outline:hover{border-color:var(--gold);background:var(--gold-dim);}
        .btn-sm{padding:6px 12px;font-size:11px;border-radius:6px;}
        .btn-danger{padding:6px 12px;background:rgba(153,27,27,0.2);color:#fca5a5;border:1px solid rgba(153,27,27,0.3);border-radius:6px;font-family:'Inter',sans-serif;font-size:11px;cursor:pointer;transition:all .2s;}
        .btn-danger:hover{background:rgba(153,27,27,0.4);}

        .stat-card{background:rgba(44,24,16,0.45);border:1px solid rgba(201,169,110,0.06);border-radius:12px;padding:20px;}

        .data-table{width:100%;border-collapse:collapse;}
        .data-table th{text-align:left;font-size:10px;letter-spacing:1px;text-transform:uppercase;color:var(--cream-muted);opacity:.5;padding:10px 14px;border-bottom:1px solid rgba(201,169,110,0.06);}
        .data-table td{padding:12px 14px;border-bottom:1px solid rgba(201,169,110,0.04);font-size:13px;vertical-align:middle;}
        .data-table tr:hover td{background:rgba(201,169,110,0.03);}

        .status-badge{padding:3px 10px;border-radius:6px;font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:.3px;display:inline-block;}
        .status-pending{background:rgba(201,169,110,0.12);color:var(--gold);}
        .status-dibayar{background:rgba(59,130,246,0.12);color:#60a5fa;}
        .status-diproses{background:rgba(168,85,247,0.12);color:#c084fc;}
        .status-dikirim{background:rgba(37,211,102,0.12);color:#4ade80;}
        .status-selesai{background:rgba(34,197,94,0.12);color:#22c55e;}
        .status-persiapan{background:rgba(201,169,110,0.12);color:var(--gold-light);}
        .status-di-jalan{background:rgba(59,130,246,0.12);color:#60a5fa;}
        .status-terkirim{background:rgba(34,197,94,0.12);color:#22c55e;}

        .glass-card{background:rgba(44,24,16,0.45);border:1px solid rgba(201,169,110,0.06);border-radius:14px;padding:20px;position:relative;overflow:hidden;}
        .glass-card::before{content:'';position:absolute;top:0;left:50%;transform:translateX(-50%);width:80px;height:1px;background:linear-gradient(90deg,transparent,var(--gold),transparent);opacity:.5;}

        .gold-line{height:1px;background:linear-gradient(to right,transparent,rgba(201,169,110,0.25),transparent);}

        .toast-wrap{position:fixed;top:80px;right:20px;z-index:300;display:flex;flex-direction:column;gap:8px;}
        .toast{padding:12px 18px;background:rgba(44,24,16,0.95);backdrop-filter:blur(20px);border:1px solid rgba(201,169,110,0.12);border-radius:10px;color:var(--cream);font-size:13px;font-weight:300;display:flex;align-items:center;gap:8px;box-shadow:0 8px 32px rgba(0,0,0,0.35);animation:tIn .4s ease forwards;max-width:340px;}
        .toast.out{animation:tOut .3s ease forwards;}
        @keyframes tIn{from{opacity:0;transform:translateX(24px)}to{opacity:1;transform:translateX(0)}}
        @keyframes tOut{from{opacity:1;transform:translateX(0)}to{opacity:0;transform:translateX(24px)}}

        .prod-img{width:48px;height:48px;border-radius:8px;object-fit:cover;flex-shrink:0;}
        .thumb-sm{width:36px;height:36px;border-radius:6px;object-fit:cover;flex-shrink:0;}

        .modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,0.7);backdrop-filter:blur(6px);z-index:200;opacity:0;pointer-events:none;transition:opacity .3s;display:flex;align-items:center;justify-content:center;padding:20px;}
        .modal-overlay.open{opacity:1;pointer-events:all;}
        .modal-box{background:rgba(44,24,16,0.97);backdrop-filter:blur(40px);border:1px solid rgba(201,169,110,0.12);border-radius:16px;width:100%;max-width:540px;max-height:90vh;overflow-y:auto;transform:scale(.95);transition:transform .3s;position:relative;}
        .modal-overlay.open .modal-box{transform:scale(1);}
        .modal-box::before{content:'';position:absolute;top:0;left:50%;transform:translateX(-50%);width:80px;height:1px;background:linear-gradient(90deg,transparent,var(--gold),transparent);}

        @media(max-width:768px){
            .admin-nav{overflow-x:auto;gap:2px;padding:0 12px;}
            .admin-nav a{white-space:nowrap;padding:6px 10px;font-size:11px;}
            .stat-grid{grid-template-columns:1fr 1fr!important;}
            .data-table{font-size:12px;}
            .data-table th,.data-table td{padding:8px 10px;}
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header class="admin-header">
        <div style="max-width:1200px;margin:0 auto;padding:0 20px;">
            <div style="display:flex;align-items:center;justify-content:space-between;height:56px;">
                <a href="{{ route('home') }}" style="display:flex;align-items:center;gap:8px;text-decoration:none;">
                    <div style="width:32px;height:32px;border-radius:8px;border:1px solid rgba(201,169,110,0.15);display:flex;align-items:center;justify-content:center;">
                        <span style="color:var(--gold);font-family:'Playfair Display',serif;font-size:15px;font-weight:700;">O</span>
                    </div>
                    <span style="font-family:'Playfair Display',serif;font-size:16px;font-weight:600;color:var(--cream);">Ovena</span>
                    <span style="font-size:10px;color:var(--maroon);background:rgba(74,18,18,0.3);padding:2px 8px;border-radius:4px;font-weight:600;letter-spacing:.5px;text-transform:uppercase;margin-left:4px;">Admin</span>
                </a>
                <div style="display:flex;align-items:center;gap:10px;">
                    <span style="font-size:12px;color:var(--cream-muted);">{{ auth()->user()->nama }}</span>
                    <a href="{{ route('home') }}" class="btn-outline btn-sm"><i data-lucide="external-link" style="width:12px;height:12px;"></i> Toko</a>
                    <form method="POST" action="{{ route('logout') }}" style="display:contents;">
                        @csrf
                        <button type="submit" class="btn-danger btn-sm"><i data-lucide="log-out" style="width:12px;height:12px;"></i> Keluar</button>
                    </form>
                </div>
            </div>
            <nav class="admin-nav">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i data-lucide="layout-dashboard" style="width:13px;height:13px;display:inline;vertical-align:-2px;margin-right:3px;"></i> Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}"><i data-lucide="cake-slice" style="width:13px;height:13px;display:inline;vertical-align:-2px;margin-right:3px;"></i> Produk</a>
                <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"><i data-lucide="clipboard-list" style="width:13px;height:13px;display:inline;vertical-align:-2px;margin-right:3px;"></i> Pesanan</a>
                <a href="{{ route('admin.deliveries.index') }}" class="{{ request()->routeIs('admin.deliveries.*') ? 'active' : '' }}"><i data-lucide="truck" style="width:13px;height:13px;display:inline;vertical-align:-2px;margin-right:3px;"></i> Pengiriman</a>
                
                {{-- Menu Pemasaran Tambahan --}}
                <a href="{{ route('admin.banners.index') }}" class="{{ request()->routeIs('admin.banners.*') ? 'active' : '' }}"><i data-lucide="image" style="width:13px;height:13px;display:inline;vertical-align:-2px;margin-right:3px;"></i> Banner</a>
                <a href="{{ route('admin.vouchers.index') }}" class="{{ request()->routeIs('admin.vouchers.*') ? 'active' : '' }}"><i data-lucide="ticket" style="width:13px;height:13px;display:inline;vertical-align:-2px;margin-right:3px;"></i> Voucher</a>
            </nav>
        </div>
    </header>

    <!-- Content -->
    <main style="max-width:1200px;margin:0 auto;padding:24px 20px 40px;">
        @yield('content')
    </main>

    <!-- Flash Toasts -->
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
        lucide.createIcons();
        document.querySelectorAll('.toast#toastFlash').forEach(t=>{
            setTimeout(()=>{t.classList.add('out');setTimeout(()=>t.remove(),300);},3500);
        });
    </script>
    @stack('scripts')
</body>
</html>