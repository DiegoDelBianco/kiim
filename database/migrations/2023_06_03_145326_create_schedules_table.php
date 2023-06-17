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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->mediumtext('report')->nullable();
            $table->date('date');
            $table->time('time')->nullable();
            $table->integer('status')->default(1);
            $table->foreignId('customer_service_id')->nullable()->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('tenancy_id')->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};