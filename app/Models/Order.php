<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'total_harga', 'status', 'alamat_pengiriman',
        'no_telp_penerima', 'nama_penerima', 'metode_pembayaran', 'catatan',  'voucher_id',
    'potongan_diskon'  
    ];

    protected function casts(): array
    {
        return ['tanggal_order' => 'datetime'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }

    public function voucher()
{
    return $this->belongsTo(Voucher::class);
}
}