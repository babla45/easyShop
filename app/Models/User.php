<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use Notifiable;

    // Explicitly specify the table name
    protected $table = 'user';

    // Define the fillable attributes
    protected $fillable = ['name', 'phone', 'location', 'email', 'password'];
}
