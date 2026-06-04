<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_pembayaran';
    protected $guarded = [];

    public function order() { return $this->belongsTo(Order::class, 'id_pesanan'); }
}
