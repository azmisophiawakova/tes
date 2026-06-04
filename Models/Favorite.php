<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_favorit';
    protected $guarded = [];

    public function user() { return $this->belongsTo(User::class, 'id_user'); }
    public function product() { return $this->belongsTo(Product::class, 'id_produk'); }
}
