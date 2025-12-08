<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('city')->nullable()->after('home_address');
            $table->decimal('distance_km', 8, 2)->nullable()->after('city');
            $table->decimal('distance_fee', 10, 2)->nullable()->after('distance_km');
            // Base price + distance fee + tip = grand total (already exists)
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['city', 'distance_km', 'distance_fee']);
        });
    }
};