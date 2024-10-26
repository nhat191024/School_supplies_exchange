<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bill;

class BillSeeder extends Seeder
{
    public function run()
    {
        Bill::create([
            'buyer_id' => 1,
            'seller_id' => 2,
            'product_id' => 1,
        ]);

        Bill::create([
            'buyer_id' => 2,
            'seller_id' => 1,
            'product_id' => 2,
        ]);

        // Add more bills as needed
    }
}
