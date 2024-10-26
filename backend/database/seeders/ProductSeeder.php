<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'category_id' => 1,
                'user_id' => 1,
                'name' => 'Basic Math Textbook',
                'purchase_date' => '2022-08-15',
                'condition' => 0, // 0 = new
                'price' => 150000,
                'description' => 'A new basic math textbook for high school students.',
                'status' => 1,
            ],
            [
                'category_id' => 2,
                'user_id' => 2,
                'name' => 'Graphite Pencils Set',
                'purchase_date' => '2023-03-10',
                'condition' => 1, // 1 = used
                'price' => 50000,
                'description' => 'A set of used graphite pencils for sketching.',
                'status' => 1,
            ],
            [
                'category_id' => 3,
                'user_id' => 3,
                'name' => 'Notebook Pack',
                'purchase_date' => '2023-09-05',
                'condition' => 0, // 0 = new
                'price' => 30000,
                'description' => 'A pack of new notebooks, suitable for school and college students.',
                'status' => 1,
            ],
            [
                'category_id' => 4,
                'user_id' => 1,
                'name' => 'Durable Backpack',
                'purchase_date' => '2022-12-22',
                'condition' => 1, // 1 = used
                'price' => 200000,
                'description' => 'A slightly used backpack, great for carrying books and supplies.',
                'status' => 1,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
