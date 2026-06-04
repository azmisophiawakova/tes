<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_verifikasi';
    protected $guarded = [];

    public function user() { return $this->belongsTo(User::class, 'id_user'); }
    public function order() { return $this->belongsTo(Order::class, 'id_pesanan'); }
    public function payment() { return $this->belongsTo(Payment::class, 'id_pembayaran'); }
}
