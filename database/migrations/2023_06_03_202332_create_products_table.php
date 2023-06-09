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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('picture')->nullable();
            $table->string('title')->nullable();
            $table->boolean('active')->nullable();
            $table->string('address')->nullable();
            $table->boolean('rent')->nullable();
            $table->boolean('sale')->nullable();
            $table->integer('rooms')->nullable();
            $table->integer('suites')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('vehicle_space')->nullable();
            $table->integer('useful_area')->nullable();
            $table->boolean('coverage')->nullable();
            $table->integer('availability')->nullable();
            $table->integer('property_entrance')->nullable();
            $table->boolean('animals')->nullable();
            $table->boolean('pool')->nullable();
            $table->integer('doorman')->nullable();
            $table->integer('property_relationship')->nullable();
            $table->decimal('condo_value', 10, 2)->nullable();
            $table->boolean('iptu')->nullable();
            $table->decimal('sell_price', 10, 2)->nullable();
            $table->decimal('rental_price', 10, 2)->nullable();
            $table->boolean('status')->nullable();
            $table->string('cep')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('uf')->nullable();
            $table->string('city')->nullable();
            $table->timestamp('terms_accept')->useCurrent();
            $table->longtext('detail')->nullable();
            $table->boolean('done')->nullable();
            $table->date('done_date')->nullable();
            $table->mediumtext('description')->nullable();
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
        Schema::dropIfExists('products');
    }
};
