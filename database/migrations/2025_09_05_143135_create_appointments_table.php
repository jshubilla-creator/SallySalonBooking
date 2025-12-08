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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('specialist_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            
            $table->date('appointment_date');
            $table->datetime('start_time');
            $table->datetime('end_time');
            
            $table->enum('status', [
                'pending', 'confirmed', 'in_progress', 'completed', 'cancelled', 'rescheduled'
            ])->default('pending');
            
            $table->text('notes')->nullable();
            $table->decimal('total_price', 10, 2);
            $table->enum('payment_status', ['pending', 'paid', 'refunded'])->default('pending');
            
            $table->boolean('is_home_service')->default(false);
            $table->text('home_address')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();

            // ✅ New tip-related fields
            $table->decimal('tip_amount', 10, 2)->default(0);
            $table->decimal('grand_total', 10, 2)->nullable();

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
