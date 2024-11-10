<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_name' => $this->faker->words(2, true), // Generates a random product name
            'category' => $this->faker->randomElement(['Electronics', 'Fashion', 'Books', 'Furniture', 'Toys']),
            'price' => $this->faker->randomFloat(2, 10, 1000), // Generates a random price between 10 and 1000
            'location' => $this->faker->city(), // Generates a random city name
            'image' => 'placeholder.png', // Placeholder image or change if you have a default image
        ];
    }
}
