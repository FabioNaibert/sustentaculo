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
        if (!Schema::hasColumn('weapons', 'player_id')) {
            Schema::table('weapons', function (Blueprint $table) {
                $table->unsignedBigInteger('player_id')->nullable();
                $table->unsignedBigInteger('history_id')->nullable();
                $table->boolean('equiped')->default(false);

                $table->foreign('player_id')->references('id')->on('players')->nullOnDelete();
                $table->foreign('history_id')->references('id')->on('histories')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('weapons', 'player_id')) {
            Schema::dropColumns('weapons', ['player_id', 'equiped', 'history_id']);
        }
    }
};
