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
        Schema::create('customer_csv_imports', function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('tenancy_id')->constrained();
            $table->integer('count_leads')->constrained();
            $table->string('status')->constrained(); // Processando, Concluído, Erro
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_csv_imports');
    }
};
