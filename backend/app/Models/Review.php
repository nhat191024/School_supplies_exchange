<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',  // ID của sản phẩm được đánh giá
        'user_id',     // ID của người dùng viết đánh giá
        'rating',      // Đánh giá, ví dụ: 1 - 5
        'comment'      // Nội dung bình luận đánh giá
    ];

    // Quan hệ với Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
