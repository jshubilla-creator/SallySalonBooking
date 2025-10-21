<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable()->after('home_address');
            }
            if (!Schema::hasColumn('appointments', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            }
            if (!Schema::hasColumn('appointments', 'tip_amount')) {
                $table->decimal('tip_amount', 10, 2)->default(0)->after('total_price');
            }
            if (!Schema::hasColumn('appointments', 'grand_total')) {
                $table->decimal('grand_total', 10, 2)->nullable()->after('tip_amount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'tip_amount', 'grand_total']);
        });
    }
};
