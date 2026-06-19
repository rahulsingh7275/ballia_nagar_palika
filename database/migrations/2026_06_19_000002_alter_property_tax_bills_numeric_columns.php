<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $columns = [
            'total_arv',
            'house_tax_current_tax',
            'house_tax_arrear',
            'house_tax_interest',
            'house_tax_total_amount',
            'water_tax_current_tax',
            'water_tax_arrear',
            'water_tax_interest',
            'water_tax_total_amount',
            'sewerage_tax_current_tax',
            'sewerage_tax_arrear',
            'sewerage_tax_interest',
            'sewerage_tax_total_amount',
            'other_tax_current_tax',
            'other_tax_arrear',
            'other_tax_interest',
            'other_tax_total_amount',
            'water_charge_current_tax',
            'water_charge_arrear',
            'water_charge_interest',
            'water_charge_total_amount',
        ];

        foreach ($columns as $column) {
            DB::statement("ALTER TABLE property_tax_bills MODIFY COLUMN {$column} DECIMAL(15,2) NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $columns = [
            'total_arv',
            'house_tax_current_tax',
            'house_tax_arrear',
            'house_tax_interest',
            'house_tax_total_amount',
            'water_tax_current_tax',
            'water_tax_arrear',
            'water_tax_interest',
            'water_tax_total_amount',
            'sewerage_tax_current_tax',
            'sewerage_tax_arrear',
            'sewerage_tax_interest',
            'sewerage_tax_total_amount',
            'other_tax_current_tax',
            'other_tax_arrear',
            'other_tax_interest',
            'other_tax_total_amount',
            'water_charge_current_tax',
            'water_charge_arrear',
            'water_charge_interest',
            'water_charge_total_amount',
        ];

        foreach ($columns as $column) {
            DB::statement("ALTER TABLE property_tax_bills MODIFY COLUMN {$column} VARCHAR(255) NULL");
        }
    }
};
