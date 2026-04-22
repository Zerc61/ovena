<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'product_id', 'rating', 'komentar'];

    // Relasi ke User (Pembeli yang mereview)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ⬇️ TAMBAHKAN RELASI INI ⬇️
    // Relasi ke Product (Produk yang direview)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}