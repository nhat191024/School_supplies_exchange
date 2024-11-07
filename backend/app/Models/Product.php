<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'price',
        'condition', // 0 = new, 1 = used
        'status',    // 1 = available, 0 = out of stock
        'image',
        'user_id',
        'purchase_date'
    ];

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Quan hệ với Review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function bill()
    {
        return $this->hasOne(Bill::class);
    }
}
