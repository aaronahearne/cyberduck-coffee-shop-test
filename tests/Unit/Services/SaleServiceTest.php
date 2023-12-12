<?php

namespace Tests\Unit\Services;

use App\Services\SaleService;
use PHPUnit\Framework\TestCase;

class SaleServiceTest extends TestCase
{
    protected SaleService $saleService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->saleService = new SaleService();
    }

    public function testCalculateCost(): void
    {
        $quantity = 5;
        $unitCost = 2.451;

        $result = $this->saleService->calculateCost($quantity, $unitCost);

        $this->assertEquals(12.26, $result); // Rounded up from 12.257
    }

    public function testCalculateSellingPrice(): void
    {
        $cost = 50.0;
        $profitMargin = 0.1;
        $shippingCost = 5.0;

        $result = $this->saleService->calculateSellingPrice($cost, $profitMargin, $shippingCost);

        $this->assertEquals(60.56, $result); // Rounded up from 61.111111
    }
}
