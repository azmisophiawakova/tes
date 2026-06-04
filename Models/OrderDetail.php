<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_detail';
    protected $guarded = [];

    public function order() { return $this->belongsTo(Order::class, 'id_pesanan'); }
    public function product() { return $this->belongsTo(Product::class, 'id_produk'); }
}
