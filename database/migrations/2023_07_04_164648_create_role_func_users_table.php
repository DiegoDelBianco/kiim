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
        Schema::create('role_func_users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nome da função que da ou tira acesso
            $table->boolean('allow')->default(true);
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('tenancy_id')->constrained('tenancies');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_func_users');
    }
};
