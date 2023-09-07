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
        Schema::create('attribute_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('weapon_id')->nullable();
            $table->unsignedBigInteger('attribute_id');
            $table->integer('points')->default(0);
            $table->timestamps();

            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
            $table->foreign('weapon_id')->references('id')->on('weapons')->nullOnDelete();
            $table->foreign('attribute_id')->references('id')->on('attributes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_points');
    }
};
