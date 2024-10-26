<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Books', 'img' => 'books.jpg'],
            ['name' => 'Stationery', 'img' => 'stationery.jpg'],
            ['name' => 'Notebooks', 'img' => 'notebooks.jpg'],
            ['name' => 'Backpacks', 'img' => 'backpacks.jpg'],
            ['name' => 'Art Supplies', 'img' => 'art_supplies.jpg'],
            ['name' => 'Electronics', 'img' => 'electronics.jpg'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
