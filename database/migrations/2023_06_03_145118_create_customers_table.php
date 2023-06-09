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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('ddi')->nullable()->default(55);
            $table->string('ddd')->nullable();
            $table->string('phone')->nullable();
            $table->string('ddi_2')->nullable()->default(55);
            $table->string('ddd_2')->nullable();
            $table->string('phone_2')->nullable();
            $table->string('whatsapp')->nullable();
            $table->date('birth')->nullable();
            $table->integer('stage_id')->default(1);
            $table->mediumtext('public_description')->nullable();
            $table->mediumtext('private_description')->nullable();
            $table->boolean('no_mail_send')->default(0);
            $table->integer('n_customer_service')->nullable()->default(0);
            $table->integer('opened')->default(2);
            $table->foreignId('website_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('team_id')->nullable()->constrained();
            $table->foreignId('tenancy_id')->constrained();
            $table->date('buy_date', 10, 2)->nullable();
            $table->date('pay_date', 10, 2)->nullable();
            $table->decimal('buy_price', 10, 2)->nullable();
            $table->decimal('seller_commission', 10, 2)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
