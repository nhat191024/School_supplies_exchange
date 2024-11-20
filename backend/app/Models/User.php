<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'name',
        'school',
        'address',
        'phone',
        'avatar',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    // Quan hệ với Product
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Quan hệ với Bill
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    // Quan hệ với Review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Quan hệ với Bill qua buyer_id
    public function purchases()
    {
        return $this->hasMany(Bill::class, 'buyer_id');
    }

    // Quan hệ với Bill qua seller_id
    public function sales()
    {
        return $this->hasMany(Bill::class, 'seller_id');
    }
}
