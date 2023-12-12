<?php

namespace Tests\Unit\Observers;

use App\Models\Sale;
use App\Observers\SaleObserver;
use App\Services\SaleService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery\MockInterface;
use Tests\TestCase;

class SaleObserverTest extends TestCase
{
    use DatabaseTransactions;

    protected SaleObserver $saleObserver;

    protected SaleService|MockInterface $mockSaleService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockSaleService = $this->mock(SaleService::class);
        $this->saleObserver = new SaleObserver($this->mockSaleService);
    }

    /** @test */
    public function it_calculates_cost_and_selling_price_when_creating_sale()
    {
        $sale = Sale::factory()->make([
            'quantity' => 5,
            'unit_cost' => 2.451,
        ]);

        $expected = [
            'cost' => 12.2,
            'selling_price' => 34.2,
        ];

        $this->mockSaleService->shouldReceive('calculateCost')
            ->once()
            ->with($sale->quantity, $sale->unit_cost)
            ->andReturn($expected['cost']);

        $this->mockSaleService->shouldReceive('calculateSellingPrice')
            ->once()
            ->with($expected['cost'], Sale::SALE_PROFIT_MARGIN, Sale::SALE_SHIPPING_COST)
            ->andReturn($expected['selling_price']);

        $this->saleObserver->creating($sale);

        $this->assertEquals($expected['cost'], $sale->cost); // Adjust this based on your expected value
        $this->assertEquals($expected['selling_price'], $sale->selling_price); // Adjust this based on your expected value
    }
}
