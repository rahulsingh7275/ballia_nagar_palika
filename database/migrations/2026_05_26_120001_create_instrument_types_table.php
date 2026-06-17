<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instrument_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrument_id')->nullable()->constrained('instruments')->nullOnDelete();
            $table->string('name')->unique();
            $table->string('code')->nullable()->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instrument_types');
    }
};
