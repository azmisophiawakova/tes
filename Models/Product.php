<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_produk';
    protected $guarded = [];

    public function store() { return $this->belongsTo(Store::class, 'id_toko'); }
    public function category() { return $this->belongsTo(Category::class, 'id_kategori'); }
    public function carts() { return $this->hasMany(Cart::class, 'id_produk'); }
    public function orderDetails() { return $this->hasMany(OrderDetail::class, 'id_produk'); }
    public function reviews() { return $this->hasMany(Review::class, 'id_produk'); }
    public function favorites() { return $this->hasMany(Favorite::class, 'id_produk'); }
}
