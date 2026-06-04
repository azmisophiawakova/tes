<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'no_hp',
        'alamat',
        'umur',
        'jenis_kelamin',
        'kendaraan',
        'plat_nomor',
        'role',
        'foto_profil',
        'status_akun',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function stores() { return $this->hasMany(Store::class, 'id_user'); }
    public function carts() { return $this->hasMany(Cart::class, 'id_user'); }
    public function orders() { return $this->hasMany(Order::class, 'id_user'); }
    public function reviews() { return $this->hasMany(Review::class, 'id_user'); }
    public function favorites() { return $this->hasMany(Favorite::class, 'id_user'); }
    public function notifications() { return $this->hasMany(Notification::class, 'id_user'); }
    public function deliveries() { return $this->hasMany(Order::class, 'id_kurir'); }
    public function verifications() { return $this->hasMany(Verification::class, 'id_user'); }
    public function monitorings() { return $this->hasMany(Monitoring::class, 'id_user'); }
}
