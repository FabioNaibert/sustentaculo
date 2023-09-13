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
        Schema::table('attribute_points', function (Blueprint $table) {
            $table->renameColumn('points', 'total_points');
            $table->integer('current_points')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('attribute_points', 'current_points');
        Schema::table('attribute_points', function (Blueprint $table) {
            $table->renameColumn('total_points', 'points');
        });
    }
};
