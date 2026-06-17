<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('metadata', function (Blueprint $table) {
            $table->date('presection_date')->nullable()->after('registration_date');
            $table->foreignId('instrument_type_id')->nullable()->after('presection_date')->constrained('instruments')->nullOnDelete();
            $table->foreignId('instrument_sub_type_id')->nullable()->after('instrument_type_id')->constrained('instrument_types')->nullOnDelete();
            $table->unsignedInteger('page_no_from')->nullable()->after('instrument_sub_type_id');
            $table->unsignedInteger('page_no_to')->nullable()->after('page_no_from');
        });
    }

    public function down(): void
    {
        Schema::table('metadata', function (Blueprint $table) {
            $table->dropConstrainedForeignId('instrument_type_id');
            $table->dropConstrainedForeignId('instrument_sub_type_id');
            $table->dropColumn(['presection_date', 'page_no_from', 'page_no_to']);
        });
    }
};
