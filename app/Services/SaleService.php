<?php

namespace App\Services;

class SaleService
{
    public function calculateCost(int $quantity, float $unitCost): float
    {
        return ceil($quantity * $unitCost * 100) / 100;
    }

    public function calculateSellingPrice(float $cost, float $profitMargin, float $shippingCost): float
    {
        $sellingPrice = $cost / (1 - $profitMargin) + $shippingCost;

        return ceil($sellingPrice * 100) / 100;
    }
}
