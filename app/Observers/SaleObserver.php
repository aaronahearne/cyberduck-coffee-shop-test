<?php

namespace App\Observers;

use App\Models\Sale;
use App\Services\SaleService;

class SaleObserver
{
    protected $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    /**
     * Handle the Sale "created" event.
     */
    public function creating(Sale $sale): void
    {
        // Use the SaleService to calculate cost and selling price
        $sale->cost = $this->saleService->calculateCost(
            $sale->quantity,
            $sale->unit_cost,
        );

        // Assign the calculated values to the Sale model
        $sale->selling_price = $this->saleService->calculateSellingPrice(
            $sale->cost,
            Sale::SALE_PROFIT_MARGIN,
            Sale::SALE_SHIPPING_COST,
        );
    }

    /**
     * Handle the Sale "updated" event.
     */
    public function updated(Sale $sale): void
    {
        //
    }

    /**
     * Handle the Sale "deleted" event.
     */
    public function deleted(Sale $sale): void
    {
        //
    }

    /**
     * Handle the Sale "restored" event.
     */
    public function restored(Sale $sale): void
    {
        //
    }

    /**
     * Handle the Sale "force deleted" event.
     */
    public function forceDeleted(Sale $sale): void
    {
        //
    }
}
