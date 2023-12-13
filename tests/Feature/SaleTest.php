<?php

namespace Tests\Feature;

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
        $data = [
            'quantity' => 5,
            'unit_cost' => 10,
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
        $data = [
            'quantity' => 5,
            'unit_cost' => 10,
        ];

        $response = $this
            ->actingAs($this->user)
            ->post(route('sale.calculate'), $data);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'cost' => 50,
            'selling_price' => 76.67,
        ]);
    }
}
