<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'password' => bcrypt('password123'),
                'school' => 'Example University',
                'address' => '123 Main St, Cityville',
                'phone' => '123-456-7890',
            ],
            [
                'id' => 2,
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'password' => bcrypt('password123'),
                'school' => 'Sample College',
                'address' => '456 Elm St, Townsville',
                'phone' => '987-654-3210',
            ],
            [
                'id' => 3,
                'name' => 'Alice Johnson',
                'email' => 'alice.johnson@example.com',
                'password' => bcrypt('password123'),
                'school' => 'Tech Institute',
                'address' => '789 Oak St, Villagetown',
                'phone' => '555-123-4567',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
