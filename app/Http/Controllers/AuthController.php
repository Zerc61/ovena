<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (auth()->check()) return redirect('/');
        return view('auth.index');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/home')->with('success', 'Selamat datang, ' . auth()->user()->nama . '!');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function showRegister()
    {
        if (auth()->check()) return redirect('/');
        return view('auth.index');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'password' => ['required', 'confirmed', Password::min(6)],
            'no_telp'  => 'nullable|string|max:20',
            'alamat'   => 'nullable|string',
        ]);

        $user = User::create([
            'nama'     => $validated['nama'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'no_telp'  => $validated['no_telp'] ?? null,
            'alamat_pengiriman' => $validated['alamat'] ?? null,
        ]);

        Auth::login($user);

        return redirect('/home')->with('success', 'Akun berhasil dibuat! Selamat datang, ' . $user->nama . '.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Berhasil logout.');
    }
}