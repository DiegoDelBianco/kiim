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
        Schema::create('extension_thermometers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenancy_id')->constrained();

            $table->string('title');

            $table->decimal('award_value', 10, 2)->nullable();
            $table->integer('set_limit_lead')->nullable();

            $table->decimal('goal', 10, 2)->nullable();
            $table->string('goal_type')->default('sell');

            $table->string('trophy_svg')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extension_thermometers');
    }
};
