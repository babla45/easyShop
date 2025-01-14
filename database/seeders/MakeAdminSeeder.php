<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MakeAdminSeeder extends Seeder
{
    public function run()
    {
        // Create a new admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'phone' => '1234567890',
            'location' => 'Admin Location',
            'is_admin' => true
        ]);

        // Or make an existing user admin by email
        User::where('email', 'your@email.com')
            ->update(['is_admin' => true]);
    }
} 