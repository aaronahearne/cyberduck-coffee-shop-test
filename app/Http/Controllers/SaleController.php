<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use App\Models\Sale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class SaleController extends Controller
{
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
}
