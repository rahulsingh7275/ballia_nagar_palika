<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyTaxBill extends Model
{
    protected $guarded = [];

    protected $casts = [
        'total_arv' => 'decimal:2',
        'house_tax_current_tax' => 'decimal:2',
        'house_tax_arrear' => 'decimal:2',
        'house_tax_interest' => 'decimal:2',
        'house_tax_total_amount' => 'decimal:2',
        'water_tax_current_tax' => 'decimal:2',
        'water_tax_arrear' => 'decimal:2',
        'water_tax_interest' => 'decimal:2',
        'water_tax_total_amount' => 'decimal:2',
        'sewerage_tax_current_tax' => 'decimal:2',
        'sewerage_tax_arrear' => 'decimal:2',
        'sewerage_tax_interest' => 'decimal:2',
        'sewerage_tax_total_amount' => 'decimal:2',
        'other_tax_current_tax' => 'decimal:2',
        'other_tax_arrear' => 'decimal:2',
        'other_tax_interest' => 'decimal:2',
        'other_tax_total_amount' => 'decimal:2',
        'water_charge_current_tax' => 'decimal:2',
        'water_charge_arrear' => 'decimal:2',
        'water_charge_interest' => 'decimal:2',
        'water_charge_total_amount' => 'decimal:2',
    ];

    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class);
    }
}
