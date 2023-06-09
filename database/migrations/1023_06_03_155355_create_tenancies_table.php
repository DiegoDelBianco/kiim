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
        Schema::create('tenancies', function (Blueprint $table) {
            $table->id();
            $table->string('subdomain');
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->string('logo')->nullable();
            $table->integer('max_users')->default(1);
            $table->integer('max_websites')->default(10);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenancies');
    }
};
