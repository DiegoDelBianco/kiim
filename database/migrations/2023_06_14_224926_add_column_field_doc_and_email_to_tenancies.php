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
        Schema::table('tenancies', function (Blueprint $table) {
            $table->string('doc')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('cep')->nullable();
            $table->string('address')->nullable();
            $table->string('address_number')->nullable();
            $table->string('complement')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('uf')->nullable();
            $table->string('assas_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenancies', function (Blueprint $table) {
            $table->dropColumn('doc');
            $table->dropColumn('email');
            $table->dropColumn('assas_id');
        });
    }
};
