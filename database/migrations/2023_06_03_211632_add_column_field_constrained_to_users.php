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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('team_id')->nullable()->constrained();
            $table->foreignId('sector_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_team_id_foreign');
            $table->dropColumn('team_id');
            $table->dropForeign('users_sector_id_foreign');
            $table->dropColumn('sector_id');
        });
    }
};
