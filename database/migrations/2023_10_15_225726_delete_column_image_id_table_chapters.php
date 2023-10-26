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
        if (Schema::hasColumn('chapters', 'image_id')) {
            Schema::dropColumns('chapters', 'image_id');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('chapters', 'image_id')) {
            Schema::table('chapters', function (Blueprint $table) {
                $table->unsignedBigInteger('image_id')->nullable();
                $table->foreign('image_id')->references('id')->on('images')->nullOnDelete();
            });
        }
    }
};