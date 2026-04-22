<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'subjudul',
        'gambar_url',
        'is_active',
        'product_id', // ⬅️ TAMBAHKAN BARIS INI
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}