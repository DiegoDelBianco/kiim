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
        Schema::create('extension_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenancy_id')->nullable()->constrained('tenancies', 'id');
            $table->string('extension');
            $table->string('key');
            $table->text('value')->nullable();
            $table->boolean('bol_value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extension_configs');
    }
};
