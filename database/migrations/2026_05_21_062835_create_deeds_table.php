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
        Schema::create('deeds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('index_id')->constrained('indexes')->cascadeOnDelete();
            $table->string('presentation_year')->nullable();
            $table->string('deed_number')->nullable();
            $table->string('party_name')->nullable();
            $table->text('property_details')->nullable();
            $table->string('village')->nullable();
            $table->string('area')->nullable();
            $table->date('registration_date')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deeds');
    }
};
