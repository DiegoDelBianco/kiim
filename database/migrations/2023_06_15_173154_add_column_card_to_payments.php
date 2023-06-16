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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('credit_card_number')->nullable();
            $table->string('credit_card_brand')->nullable();
            $table->string('credit_card_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('credit_card_number');
            $table->dropColumn('credit_card_brand');
            $table->dropColumn('credit_card_token');
        });
    }
};
