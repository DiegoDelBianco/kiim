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
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('picture')->nullable();
            $table->string('api_token')->nullable();
            $table->string('flow')->nullable();
            $table->string('template')->nullable();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('team_id')->nullable()->constrained();
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
        Schema::dropIfExists('websites');
    }
};
