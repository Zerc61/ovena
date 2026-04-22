<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_voucher',
        'tipe',
        'nilai',
        'min_belanja',
        'kuota',
        'berlaku_sampai',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'berlaku_sampai' => 'date',
    ];
}