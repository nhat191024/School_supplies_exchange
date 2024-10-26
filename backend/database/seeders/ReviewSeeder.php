<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        Review::create([
            'bill_id' => 1,
            'buyer_id' => 1,
            'seller_id' => 2,
            'rating' => 4,
            'comment' => 'Good quality textbook. Useful and affordable.',
        ]);

        Review::create([
            'bill_id' => 2,
            'buyer_id' => 2,
            'seller_id' => 1,
            'rating' => 5,
            'comment' => 'The notebooks are great! Perfect for school.',
        ]);

        // Add more reviews as needed
    }
}
