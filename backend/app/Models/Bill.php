<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',          // Ví dụ: "paid", "pending", "completed"
        'payment_method',   // Ví dụ: "cash on delivery", "online payment"
        'shipping_address'  // Địa chỉ giao hàng
    ];
}
