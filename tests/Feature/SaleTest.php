<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SaleTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_sale(): void
    {
        $user = User::factory()->create();

        $data = [
            'quantity' => 5,
            'unit_cost' => 10,
        ];

        $response = $this
            ->actingAs($user)
            ->from('/dashboard')
            ->post(route('sale.store'), $data);

        $response->assertRedirect();

        $this->assertDatabaseHas('sales', [
            'quantity' => $data['quantity'],
            'unit_cost' => $data['unit_cost'],
        ]);
    }
}
