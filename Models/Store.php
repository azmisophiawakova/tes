<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_toko';
    protected $guarded = [];

    public function user() { return $this->belongsTo(User::class, 'id_user'); }
    public function products() { return $this->hasMany(Product::class, 'id_toko'); }
}
