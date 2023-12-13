<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use App\Models\Sale;
use App\Services\SaleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class SaleController extends Controller
{
    public function __construct(private SaleService $saleService)
    {
    }

    public function index(): Response
    {
        return Inertia::render('Sales/Dashboard', [
            'sales' => Sale::all(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function create(StoreSaleRequest $request): RedirectResponse
    {
        $sale = Sale::create($request->validated());

        return Redirect::route('dashboard')->with([
            'sale' => $sale,
        ]);
    }

    public function calculate(StoreSaleRequest $request)
    {
        $sale = Sale::make($request->validated());

        $sale->cost = $this->saleService->calculateCost(
            $sale->quantity,
            $sale->unit_cost,
        );

        $sale->selling_price = $this->saleService->calculateSellingPrice(
            $sale->cost,
            Sale::SALE_PROFIT_MARGIN,
            Sale::SALE_SHIPPING_COST,
        );

        return response()->json($sale->only(['cost', 'selling_price']));
    }
}
