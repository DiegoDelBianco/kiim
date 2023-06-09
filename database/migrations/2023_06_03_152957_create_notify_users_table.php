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
        Schema::create('notify_users', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('text')->nullable();
            $table->string('style')->nullable();
            $table->timestamp('shoot');
            $table->foreignId('team_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
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
        Schema::dropIfExists('notify_users');
    }
};
