<?php

namespace Tests\Unit\Observers;

use App\Exceptions\MissingAttributeForCalculationException;
use App\Models\Coffee;
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

    public function test_creating_without_coffee_throws_error()
    {
        $sale = Sale::factory()->make([
            'coffee_id' => null,
        ]);

        $this->expectException(MissingAttributeForCalculationException::class);
        $this->expectExceptionMessage('Missing attribute required for calculation: coffee');

        $this->saleObserver->creating($sale);
    }

    public function test_creating_without_sale_quantity_throws_error()
    {
        $sale = Sale::factory()->make([
            'quantity' => null,
        ]);

        $this->expectException(MissingAttributeForCalculationException::class);
        $this->expectExceptionMessage('Missing attribute required for calculation: quantity');

        $this->saleObserver->creating($sale);
    }

    public function test_creating_without_sale_unit_cost_throws_error()
    {
        $sale = Sale::factory()->make([
            'unit_cost' => null,
        ]);

        $this->expectException(MissingAttributeForCalculationException::class);
        $this->expectExceptionMessage('Missing attribute required for calculation: unit_cost');

        $this->saleObserver->creating($sale);
    }

    public function test_creating_without_coffee_profit_margin_throws_error()
    {
        $coffee = Coffee::factory()->make([
            'profit_margin' => null,
        ]);
        $sale = Sale::factory()->make();
        $sale->coffee()->associate($coffee);

        $this->expectException(MissingAttributeForCalculationException::class);
        $this->expectExceptionMessage('Missing attribute required for calculation: coffee profit_margin');

        $this->saleObserver->creating($sale);
    }

    public function test_creating_calculates_cost_and_selling_price_when_creating_sale()
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
            ->with($expected['cost'], $sale->coffee->profit_margin, Sale::SALE_SHIPPING_COST)
            ->andReturn($expected['selling_price']);

        $this->saleObserver->creating($sale);

        $this->assertEquals($expected['cost'], $sale->cost);
        $this->assertEquals($expected['selling_price'], $sale->selling_price);
    }
}
