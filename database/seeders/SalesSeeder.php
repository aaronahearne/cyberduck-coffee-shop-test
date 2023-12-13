<?php

namespace Database\Seeders;

use App\Models\Coffee;
use App\Models\Sale;
use Illuminate\Database\Seeder;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Coffee::all()->each(function (Coffee $coffee) {
            Sale::factory()
                ->count(2)
                ->for($coffee)
                ->create();
        });
    }
}
