<?php

namespace Database\Seeders;

use App\Models\Coffee;
use Illuminate\Database\Seeder;

class CoffeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Coffee::factory()->create([
            'name' => 'Arabic coffee',
            'profit_margin' => 0.15,
        ]);

        Coffee::factory()->create([
            'name' => 'Gold coffee',
            'profit_margin' => 0.25,
        ]);
    }
}
