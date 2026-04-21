<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'kategori_id', 'nama_produk', 'deskripsi', 'harga', 'stok',
        'url_gambar', 'is_fragile', 'umur_simpan',
    ];

    protected function casts(): array
    {
        return ['is_fragile' => 'boolean'];
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function getImageUrlAttribute()
{
    if ($this->url_gambar) {
        return \Storage::url($this->url_gambar);
    }
    return null;
}
}