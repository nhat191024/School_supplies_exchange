<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'email' => 'account1@gmail.com',
            'password' => Hash::make('password'),
            'name' => 'John Doe',
            'school' => 'ABC High School',
            'address' => '123 Main St',
            'phone' => '1234567890',
            'avatar' => 'avatar1.jpg',
            'role' => 1, // 1 for regular user, or change according to your app's logic
        ]);

        User::create([
            'email' => 'account2@gmail.com ',
            'password' => Hash::make('password'),
            'name' => 'Jane Smith',
            'school' => 'XYZ University',
            'address' => '456 Side St',
            'phone' => '0987654321',
            'avatar' => 'avatar2.jpg',
            'role' => 1,
        ]);

        // Add more users as needed
    }
}
