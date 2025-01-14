<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class MakeUserAdmin extends Command
{
    protected $signature = 'user:make-admin {email?}';
    protected $description = 'Make a user an admin';

    public function handle()
    {
        $email = $this->argument('email');
        
        if ($email) {
            $user = User::where('email', $email)->first();
        } else {
            $user = User::first();
        }

        if (!$user) {
            $this->error('User not found!');
            return;
        }

        $user->update(['is_admin' => true]);
        $this->info("User {$user->name} is now an admin!");
    }
} 