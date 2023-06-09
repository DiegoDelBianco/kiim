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
        Schema::create('customer_timelines', function (Blueprint $table) {
            $table->id();
            $table->string('event')->default('Cliente inserido no sistema.');
            $table->integer('type')->default(5);
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('customer_service_id')->nullable()->constrained();
            $table->foreignId('customer_id')->constrained();
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
        Schema::dropIfExists('customer_timelines');
    }
};
