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
        Schema::create('extensions', function (Blueprint $table) {
            $table->id();
            $table->string('extension');
            $table->foreignId('tenancy_id')->constrained();
            $table->boolean('active')->default(true);
            $table->boolean('tigger_view_home_all')->default(false);
            $table->boolean('tigger_view_home_basic')->default(false);
            $table->boolean('tigger_view_home_magener')->default(false);
            $table->boolean('tigger_view_home_team_maneger')->default(false);
            $table->boolean('tigger_view_home_admin')->default(false);
            $table->boolean('tigger_view_menu_all')->default(false);
            $table->boolean('tigger_view_menu_basic')->default(false);
            $table->boolean('tigger_view_menu_magener')->default(false);
            $table->boolean('tigger_view_menu_team_maneger')->default(false);
            $table->boolean('tigger_view_menu_admin')->default(false);
            $table->boolean('tigger_monthend_close')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extensions');
    }
};
