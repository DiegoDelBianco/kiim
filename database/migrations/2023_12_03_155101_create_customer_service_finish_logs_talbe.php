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
        Schema::create('customer_service_finish_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_service_id')->constrained('customer_services');
            $table->foreignId('reason_finish_id')->constrained('reason_finishes');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('customer_stage_id')->constrained('stages');
            $table->foreignId('customer_service_stage_id')->constrained('stages');
            $table->foreignId('customer_id')->constrained('customers');

            $table->foreignId('tenancy_id')->constrained('tenancies');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_service_finish_logs');
    }
};
