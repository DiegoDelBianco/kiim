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
        Schema::create('sys_product_tenancies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sys_product_id')->constrained();
            $table->foreignId('tenancy_id')->constrained();
            $table->string('status')->default('await_payment');;
            $table->string('cycle');
            $table->string('assas_sub_id')->nullable();
            $table->string('credit_card_number')->nullable();
            $table->string('credit_card_brand')->nullable();
            $table->string('credit_card_token')->nullable();
            $table->date('last_payment')->nullable();
            $table->date('next_payment')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_product_tenancies');
    }
};
