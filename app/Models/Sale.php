<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    const SALE_PROFIT_MARGIN = 0.25;

    const SALE_SHIPPING_COST = 10.00;

    protected $fillable = [
        'unit_cost',
        'quantity',
        'cost',
        'selling_price',
    ];
}
