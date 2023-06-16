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
        Schema::create('sys_products', function (Blueprint $table) {
            $table->id();
            $table->string('group'); // Agrupamento de pacotes por nivel
            $table->integer('nivel'); // Nivel no agrupamento
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('add_customers')->default(0);
            $table->integer('add_websites')->default(0);
            $table->integer('add_users')->default(0);
            $table->decimal('monthly_price', 10, 2)->nullable(); // Mensal
            $table->decimal('quarterly_price', 10, 2)->nullable(); // Trimestral
            $table->decimal('semiannually_price', 10, 2)->nullable(); // Semetral
            $table->decimal('yearly_price', 10, 2)->nullable(); // Anual
            $table->softDeletes();
            $table->timestamps();
        });
    }
    //insert into sys_products (sys_products.group, nivel, name, description, add_customers, add_websites, add_users, monthly_price, quarterly_price, semiannually_price, yearly_price) values('full', 2, 'Pacote Intermediário', 'Para você que já está com uma demanda grande!', 10000, 20, 5, 300.00, 800.00, 1500.00, 2800.00 );

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_products');
    }
};
