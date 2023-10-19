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
        if (Schema::hasColumn('attribute_points', 'player_id')) {
            Schema::table('attribute_points', function (Blueprint $table) {
                $table->unsignedBigInteger('player_id')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('attribute_points', 'player_id')) {
            Schema::table('attribute_points', function (Blueprint $table) {
                $table->unsignedBigInteger('player_id')->nullable(false)->change();
            });
        }
    }
};
