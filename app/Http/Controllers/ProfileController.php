<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'no_telp'  => 'nullable|string|max:20',
            'alamat'   => 'nullable|string',
        ]);

        $user->update([
            'nama'              => $validated['nama'],
            'email'             => $validated['email'],
            'no_telp'           => $validated['no_telp'],
            'alamat_pengiriman' => $validated['alamat'],
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password'  => 'required|current_password',
            'password'          => 'required|confirmed|min:6',
        ]);

        auth()->user()->update([
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}