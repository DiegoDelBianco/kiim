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
        Schema::table('extensions', function (Blueprint $table) {
            /* if columns names
            tigger_view_home_magener
            tigger_view_home_team_maneger
            tigger_view_menu_magener
            tigger_view_menu_team_maneger
            */
            $table->renameColumn('tigger_view_home_magener', 'tigger_view_home_manager');
            $table->renameColumn('tigger_view_home_team_maneger', 'tigger_view_home_team_manager');
            $table->renameColumn('tigger_view_menu_magener', 'tigger_view_menu_manager');
            $table->renameColumn('tigger_view_menu_team_maneger', 'tigger_view_menu_team_manager');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('extensions', function (Blueprint $table) {
            //
        });
    }
};
