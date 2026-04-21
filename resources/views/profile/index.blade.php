@extends('layouts.app')
@section('content')
<div style="max-width:600px;margin:0 auto;padding:28px 20px 40px;">
    <h1 style="font-size:24px;font-weight:600;color:var(--cream);margin-bottom:24px;">Profil Saya</h1>

    <form method="POST" action="{{ route('profile.update') }}" style="background:rgba(44,24,16,0.5);border:1px solid rgba(201,169,110,0.06);border-radius:14px;padding:24px;margin-bottom:20px;position:relative;overflow:hidden;">
        <div style="position:absolute;top:0;left:50%;transform:translateX(-50%);width:80px;height:1px;background:linear-gradient(90deg,transparent,var(--gold),transparent);"></div>
        @csrf
        <h3 style="font-size:15px;font-weight:600;color:var(--cream);margin-bottom:18px;">Data Pribadi</h3>
        <div style="margin-bottom:14px;"><label class="form-label">Nama</label><input class="form-input" name="nama" value="{{ auth()->user()->nama }}" required></div>
        <div style="margin-bottom:14px;"><label class="form-label">Email</label><input class="form-input" type="email" name="email" value="{{ auth()->user()->email }}" required></div>
        <div style="margin-bottom:14px;"><label class="form-label">No. Telepon</label><input class="form-input" name="no_telp" value="{{ auth()->user()->no_telp }}"></div>
        <div style="margin-bottom:18px;"><label class="form-label">Alamat Default</label><textarea class="form-input" name="alamat" rows="3" style="resize:none;font-family:'Inter',sans-serif;">{{ auth()->user()->alamat_pengiriman }}</textarea></div>
        <button type="submit" class="btn-gold" style="padding:11px 24px;">Simpan Perubahan</button>
    </form>

    <form method="POST" action="{{ route('profile.password') }}" style="background:rgba(44,24,16,0.5);border:1px solid rgba(201,169,110,0.06);border-radius:14px;padding:24px;position:relative;overflow:hidden;">
        <div style="position:absolute;top:0;left:50%;transform:translateX(-50%);width:80px;height:1px;background:linear-gradient(90deg,transparent,var(--gold),transparent);"></div>
        @csrf
        <h3 style="font-size:15px;font-weight:600;color:var(--cream);margin-bottom:18px;">Ubah Password</h3>
        <div style="margin-bottom:14px;"><label class="form-label">Password Saat Ini</label><input class="form-input" type="password" name="current_password" required></div>
        <div style="margin-bottom:14px;"><label class="form-label">Password Baru</label><input class="form-input" type="password" name="password" required></div>
        <div style="margin-bottom:18px;"><label class="form-label">Konfirmasi Password Baru</label><input class="form-input" type="password" name="password_confirmation" required></div>
        <button type="submit" class="btn-outline" style="padding:11px 24px;">Ubah Password</button>
    </form>
</div>
@endsection