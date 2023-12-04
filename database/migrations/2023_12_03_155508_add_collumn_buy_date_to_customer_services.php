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
        Schema::table('customer_services', function (Blueprint $table) {

            $table->date('buy_date')->nullable();
            $table->date('paid_date')->nullable();
            $table->date('cofirm_sell')->nullable();
            $table->date('signature_date')->nullable();
            $table->date('delivery_keys_date')->nullable();
            $table->date('next_contact_date')->nullable();

            $table->foreignId('reason_finish_id')->nullable()->constrained('reason_finishes', 'id');
            $table->foreignId('stage_id')->nullable()->constrained('stages', 'id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_services', function (Blueprint $table) {
            $table->dropColumn('buy_date');
            $table->dropColumn('paid_date');
            $table->dropColumn('cofirm_sell');
            $table->dropColumn('signature_date');
            $table->dropColumn('delivery_keys_date');
            $table->dropColumn('next_contact_date');

            $table->dropForeign('customer_services_reason_finish_id_foreign');
            $table->dropForeign('customer_services_stage_id_foreign');

            $table->dropColumn('reason_finish_id');
            $table->dropColumn('stage_id');
        });
    }
};
