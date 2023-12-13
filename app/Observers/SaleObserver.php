<?php

namespace App\Observers;

use App\Exceptions\MissingAttributeForCalculationException;
use App\Models\Sale;
use App\Services\SaleService;

class SaleObserver
{
    protected SaleService $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    /**
     * Handle the Sale "created" event.
     */
    public function creating(Sale $sale): void
    {
        $requiredAttributes = ['coffee', 'quantity', 'unit_cost'];

        foreach ($requiredAttributes as $attribute) {
            if (empty($sale->$attribute)) {
                throw new MissingAttributeForCalculationException($attribute);
            }
        }

        if (empty($sale->coffee->profit_margin)) {
            throw new MissingAttributeForCalculationException('coffee profit_margin');
        }

        // Use the SaleService to calculate cost
        $sale->cost = $this->saleService->calculateCost(
            $sale->quantity,
            $sale->unit_cost,
        );

        // Assign the calculated values to the Sale model
        $sale->selling_price = $this->saleService->calculateSellingPrice(
            $sale->cost,
            $sale->coffee->profit_margin,
            Sale::SALE_SHIPPING_COST,
        );
    }
}
