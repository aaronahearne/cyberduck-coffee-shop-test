<?php

namespace Tests\Feature;

use App\Models\Coffee;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SaleTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_can_create_sale(): void
    {
        $coffee = Coffee::factory()->create();

        $data = [
            'quantity' => 5,
            'unit_cost' => 10,
            'coffee_id' => $coffee->id,
        ];

        $response = $this
            ->actingAs($this->user)
            ->from('/dashboard')
            ->post(route('sale.store'), $data);

        $response->assertRedirect();

        $this->assertDatabaseHas('sales', [
            'quantity' => $data['quantity'],
            'unit_cost' => $data['unit_cost'],
        ]);
    }

    public function test_can_calculate_sale()
    {
        $coffee = Coffee::factory()->create([
            'profit_margin' => '0.92',
        ]);

        $data = [
            'quantity' => 5,
            'unit_cost' => 10,
            'coffee_id' => $coffee->id,
        ];

        $response = $this
            ->actingAs($this->user)
            ->post(route('sale.calculate'), $data);

        $response->assertStatus(200);

        // Selling Price = (Cost / ( 1 - {Profit-margin} ) ) + {Shipping-cost}
        $expectedCost = ceil($data['quantity'] * $data['unit_cost'] * 100) / 100;
        $expectedSellingPrice = ($expectedCost / (1 - $coffee->profit_margin)) + Sale::SALE_SHIPPING_COST;
        $expectedSellingPrice = ceil($expectedSellingPrice * 100) / 100;

        $response->assertJsonFragment([
            'cost' => $expectedCost,
            'selling_price' => $expectedSellingPrice,
        ]);
    }
}
