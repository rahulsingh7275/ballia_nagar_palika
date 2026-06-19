<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('property_tax_bills', function (Blueprint $table) {

    $table->id();
    $table->string('block_id')->nullable();
    $table->string('ulb_id')->nullable();
    $table->string('old_property_id')->nullable();
    $table->string('property_id')->nullable();
    $table->string('zone_id')->nullable();
    $table->string('ward_id')->nullable();
    $table->string('mohalla_id')->nullable();
    $table->string('house_no')->nullable();

    $table->string('owner_name')->nullable();
    $table->string('father_name')->nullable();
    $table->text('address')->nullable();
    $table->string('mobile')->nullable();

    $table->string('number_of_floors')->nullable();
    $table->string('rebate_type_id')->nullable();
    $table->string('property_type_id')->nullable();
    $table->string('location_of_road_id')->nullable();
    $table->string('nature_of_house_id')->nullable();

    $table->string('total_area_of_property')->nullable();
    $table->string('property_useas_id')->nullable();

    $table->string('bill_number')->nullable();
    $table->string('bill_date')->nullable();
    $table->string('financial_year')->nullable();

    $table->decimal('total_arv', 15, 2)->nullable();

    $table->decimal('house_tax_current_tax', 15, 2)->nullable();
    $table->decimal('house_tax_arrear', 15, 2)->nullable();
    $table->decimal('house_tax_interest', 15, 2)->nullable();
    $table->decimal('house_tax_total_amount', 15, 2)->nullable();

    $table->decimal('water_tax_current_tax', 15, 2)->nullable();
    $table->decimal('water_tax_arrear', 15, 2)->nullable();
    $table->decimal('water_tax_interest', 15, 2)->nullable();
    $table->decimal('water_tax_total_amount', 15, 2)->nullable();

    $table->string('carpet_area')->nullable();
    $table->string('covered_area')->nullable();

    $table->decimal('sewerage_tax_current_tax', 15, 2)->nullable();
    $table->decimal('sewerage_tax_arrear', 15, 2)->nullable();
    $table->decimal('sewerage_tax_interest', 15, 2)->nullable();
    $table->decimal('sewerage_tax_total_amount', 15, 2)->nullable();

    $table->decimal('other_tax_current_tax', 15, 2)->nullable();
    $table->decimal('other_tax_arrear', 15, 2)->nullable();
    $table->decimal('other_tax_interest', 15, 2)->nullable();
    $table->decimal('other_tax_total_amount', 15, 2)->nullable();

    $table->decimal('water_charge_current_tax', 15, 2)->nullable();
    $table->decimal('water_charge_arrear', 15, 2)->nullable();
    $table->decimal('water_charge_interest', 15, 2)->nullable();
    $table->decimal('water_charge_total_amount', 15, 2)->nullable();

    $table->string('chuk_number')->nullable();

    $table->string('latitude')->nullable();
    $table->string('longitude')->nullable();

    $table->string('previous_year_advance_house')->nullable();
    $table->string('previous_year_advance_water')->nullable();
    $table->string('previous_year_advance_sewerage')->nullable();
    $table->string('previous_year_advance_other')->nullable();
    $table->string('previous_year_advance_water_charge')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_tax_bills');
    }
};
