<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_pesanan';
    protected $guarded = [];

    public function user() { return $this->belongsTo(User::class, 'id_user'); }
    public function store() { return $this->belongsTo(Store::class, 'id_toko'); }
    public function kurir() { return $this->belongsTo(User::class, 'id_kurir'); }
    public function orderDetails() { return $this->hasMany(OrderDetail::class, 'id_pesanan'); }
    public function payment() { return $this->hasOne(Payment::class, 'id_pesanan'); }
    public function verification() { return $this->hasOne(Verification::class, 'id_pesanan'); }
}
