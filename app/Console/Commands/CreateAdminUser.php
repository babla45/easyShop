<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create';
    protected $description = 'Create an admin user';

    public function handle()
    {
        $name = $this->ask('What is the admin name?');
        $email = $this->ask('What is the admin email?');
        $password = $this->secret('What is the admin password?');
        $phone = $this->ask('What is the admin phone number?');
        $location = $this->ask('What is the admin location?');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'phone' => $phone,
            'location' => $location,
            'is_admin' => true
        ]);

        $this->info("Admin user {$user->name} created successfully!");
    }
} 