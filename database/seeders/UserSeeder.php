<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama'     => 'Admin Ovena',
            'email'    => 'admin@ovena.id',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'no_telp'  => '02112345678',
        ]);

        User::create([
            'nama'               => 'Budi Santoso',
            'email'              => 'budi@email.com',
            'password'           => Hash::make('budi123'),
            'role'               => 'customer',
            'no_telp'            => '081234567890',
            'alamat_pengiriman'  => 'Jl. Gandaria Tengah No. 5, Jakarta Selatan',
        ]);
    }
}