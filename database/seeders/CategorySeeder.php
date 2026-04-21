<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Roti Klasik', 'Pastry', 'Kue & Cake', 'Roti Sehat',
            'Cookies', 'Minuman', 'Paket / Hamper',
        ];
        foreach ($categories as $nama) {
            Category::create(['nama_kategori' => $nama]);
        }
    }
}