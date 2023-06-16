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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('await_payment');
            $table->date('limit_date')->nullable();
            $table->string('cupom')->nullable();
            $table->integer('discount_type')->nullable();
            $table->decimal('discount_value', 10, 2)->nullable(); 
            $table->integer('discount_percentage')->nullable(); 
            $table->decimal('value', 10, 2); 
            $table->decimal('totals', 10, 2); 
            $table->foreignId('sys_product_tenancy_id')->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
