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
        Schema::table('customers', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->constrained();
            $table->foreignId('customer_timeline_id')->nullable()->constrained();
            $table->foreignId('customer_service_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign('customers_product_id_foreign');
            $table->dropColumn('product_id');
            $table->dropForeign('customers_customer_timeline_id_foreign');
            $table->dropColumn('customer_timeline_id');
            $table->dropForeign('customers_customer_service_id_foreign');
            $table->dropColumn('customer_service_id');
            //
        });
    }
};
