<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('metadata', function (Blueprint $table) {
            $table->string('party_type')->nullable()->after('party_name');
            $table->string('relation_name')->nullable()->after('party_type');
            $table->foreignId('district_id')->nullable()->after('relation_name')->constrained('districts')->nullOnDelete();
            $table->foreignId('vault_registration_office_id')->nullable()->after('district_id')->constrained('vault_registration_offices')->nullOnDelete();
            $table->string('circle')->nullable()->after('vault_registration_office_id');
            $table->string('khata_no')->nullable()->after('circle');
            $table->string('khasra_no')->nullable()->after('khata_no');
        });
    }

    public function down(): void
    {
        Schema::table('metadata', function (Blueprint $table) {
            $table->dropConstrainedForeignId('district_id');
            $table->dropConstrainedForeignId('vault_registration_office_id');
            $table->dropColumn(['party_type', 'relation_name', 'circle', 'khata_no', 'khasra_no']);
        });
    }
};
