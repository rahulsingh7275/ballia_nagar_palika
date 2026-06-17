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
        Schema::create('indexes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')->constrained('states')->cascadeOnDelete();
            $table->foreignId('district_id')->constrained('districts')->cascadeOnDelete();
            $table->foreignId('vault_registration_office_id')->constrained('vault_registration_offices')->cascadeOnDelete();
            $table->string('volume_year')->nullable();
            $table->string('book_number')->nullable();
            $table->string('volume_number')->nullable();
            $table->boolean('is_volume_forwarded')->default(false);
            $table->string('status')->default('pending');
            $table->boolean('locked')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indexes');
    }
};
