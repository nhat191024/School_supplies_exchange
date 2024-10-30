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
}
