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

    // Specify the primary key column
    protected $primaryKey = 'product_id';

    // Disable auto-incrementing if necessary (if `product_id` is not auto-incrementing)
    public $incrementing = false;

    // Specify the primary key data type
    protected $keyType = 'int';
}
