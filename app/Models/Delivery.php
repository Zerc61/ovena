<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'order_id', 'nama_kurir', 'no_telp_kurir', 'plat_kendaraan',
        'status_pengantaran', 'waktu_berangkat', 'waktu_sampai',
    ];

    protected function casts(): array
    {
        return [
            'waktu_berangkat' => 'datetime',
            'waktu_sampai' => 'datetime',
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}