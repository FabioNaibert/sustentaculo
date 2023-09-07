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
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->longText('text')->nullable();
            $table->unsignedBigInteger('previous_id')->nullable();
            $table->unsignedBigInteger('history_id');
            $table->unsignedBigInteger('image_id')->nullable();
            $table->timestamps();

            $table->foreign('previous_id')->references('id')->on('chapters')->onDelete('cascade');
            $table->foreign('history_id')->references('id')->on('histories')->onDelete('cascade');
            $table->foreign('image_id')->references('id')->on('images')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chapters');
    }
};
