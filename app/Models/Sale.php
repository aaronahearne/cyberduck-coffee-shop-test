<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    use HasFactory;

    const SALE_SHIPPING_COST = 10.00;

    protected $fillable = [
        'unit_cost',
        'quantity',
        'cost',
        'selling_price',
        'coffee_id',
    ];

    public function coffee(): BelongsTo
    {
        return $this->belongsTo(Coffee::class);
    }
}
