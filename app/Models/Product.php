<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Specify the fillable fields
    protected $fillable = [
        'product_name',
        'category',
        'price',
        'location',
        'image',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
