<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',        // Tên của danh mục, ví dụ: "Sách", "Dụng cụ học tập"
        'description'  // Mô tả về danh mục
    ];

    // Quan hệ với Product
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
