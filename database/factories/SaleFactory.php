<?php

namespace Database\Factories;

use App\Models\Coffee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'coffee_id' => Coffee::factory(),
            'unit_cost' => fake()->randomFloat(2, 1, 100),
            'quantity' => fake()->numberBetween(1, 10),
            'cost' => fake()->randomFloat(2, 1, 100),
            'selling_price' => fake()->randomFloat(2, 1, 100),
        ];
    }
}
