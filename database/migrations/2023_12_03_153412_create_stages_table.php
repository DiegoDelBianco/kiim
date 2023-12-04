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
        Schema::create('stages', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->integer('order')->default(0);
            $table->integer('funnel_order')->default(0);

            $table->boolean('is_rearranged_default')->default(false); // Padrão para quando cliente for remanejado
            $table->boolean('is_buy_cancel_default')->default(false); // Padrão para quando compra for cancelada

            $table->boolean('is_customer_default')->default(false); // Padrão para quando o cliente entrar
            $table->boolean('is_customer_service_default')->default(false); // Padrão para quando o iniciar atendimento
            $table->boolean('is_new')->default(false); // Não foi atendido
            $table->boolean('is_buy_pending')->default(false); // Pós venda
            $table->boolean('is_buy')->default(false); // Pós venda confirmada
            $table->boolean('is_deleted')->default(false); // Deletado
            $table->boolean('is_paid')->default(false); // Já esta pago
            $table->boolean('is_avaliable_to_cs')->default(false); // Se esta disponivel para atendimento
            $table->boolean('is_delivery_keys')->default(false); // As chaves ja foram entregues
            $table->boolean('is_waiting')->default(false); // Contrato assinado

            $table->boolean('rel_basic_view')->default(true);

            $table->boolean('can_init')->default(false);

            $table->foreignId('tenancy_id')->constrained('tenancies');

            $table->softDeletes();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stages');
    }
};
