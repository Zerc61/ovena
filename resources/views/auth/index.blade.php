<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login & Daftar — Ovena</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/auth/style.css') }}" />
  </head>
  <body>
    <div class="cursor-glow" id="cursorGlow"></div>
    <div class="bg-blob bg-blob-1"></div>
    <div class="bg-blob bg-blob-2"></div>
    <div class="bg-blob bg-blob-3"></div>

    {{-- Toast untuk flash message --}}
    <div class="toast-container" id="toastBox">
      @session('success')
        <div class="toast">{{ $message }}</div>
      @endsession
    </div>

    <div class="auth-container">
      <div class="auth-logo">
        <h1>Ove<span>na</span></h1>
        <p>Bakery Premium</p>
      </div>

      <div class="auth-card">
        <div class="auth-tabs">
          <button class="auth-tab active" data-tab="login">Login</button>
          <button class="auth-tab" data-tab="daftar">Daftar</button>
          <div class="tab-indicator" id="tabIndicator"></div>
        </div>

        <div class="auth-panels">

          {{-- ========== LOGIN ========== --}}
          <div class="auth-panel active" id="panel-login">
            @if ($errors->any())
              <div class="error-msg show">
                @foreach ($errors->all() as $error)
                  <p>{{ $error }}</p>
                @endforeach
              </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="form-login">
              @csrf
              <div class="field">
                <label>E-mail</label>
                <input
                  type="email"
                  name="email"
                  id="l-email"
                  value="{{ old('email') }}"
                  placeholder="contoh@email.com"
                  required
                />
              </div>
              <div class="field">
                <label>Kata Sandi</label>
                <div class="pw-wrap">
                  <input
                    type="password"
                    name="password"
                    id="l-pass"
                    placeholder="Masukkan kata sandi"
                    required
                  />
                  <button type="button" class="pw-btn" onclick="togglePw('l-pass', this)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                      <circle cx="12" cy="12" r="3"/>
                    </svg>
                  </button>
                </div>
              </div>
              <button type="submit" class="btn-submit">
                <span>Login</span>
              </button>
            </form>
          </div>

          {{-- ========== DAFTAR ========== --}}
          <div class="auth-panel" id="panel-daftar">
            @if ($errors->any() && request()->is('register'))
              <div class="error-msg show">
                @foreach ($errors->all() as $error)
                  <p>{{ $error }}</p>
                @endforeach
              </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="form-daftar">
              @csrf
              <div class="field">
                <label>Nama Lengkap</label>
                <input
                  type="text"
                  name="nama"
                  id="d-nama"
                  value="{{ old('nama') }}"
                  placeholder="Nama lengkap kamu"
                  required
                />
              </div>
              <div class="field">
                <label>E-mail</label>
                <input
                  type="email"
                  name="email"
                  id="d-email"
                  value="{{ old('email') }}"
                  placeholder="contoh@email.com"
                  required
                />
              </div>
              <div class="field">
                <label>Kata Sandi</label>
                <div class="pw-wrap">
                  <input type="password" name="password" id="d-pass" placeholder="Min. 6 karakter" required>
                  <button type="button" class="pw-btn" onclick="togglePw('d-pass', this)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                      <circle cx="12" cy="12" r="3"/>
                    </svg>
                  </button>
                </div>
              </div>
              <div class="field">
                <label>Konfirmasi Password</label>
                <div class="pw-wrap">
                  <input type="password" name="password_confirmation" id="d-pass2" placeholder="Konfirmasi kata sandi" required>
                  <button type="button" class="pw-btn" onclick="togglePw('d-pass2', this)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                      <circle cx="12" cy="12" r="3"/>
                    </svg>
                  </button>
                </div>
              </div>
              <button type="submit" class="btn-submit">
                <span>Daftar</span>
              </button>
            </form>
          </div>

        </div>
      </div>

      <div class="back-link">
        <a href="{{ route('home') }}">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14">
            <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
          </svg>
          Kembali ke beranda
        </a>
      </div>
    </div>

    <script src="{{ asset('js/auth/script.js') }}"></script>
  </body>
</html>