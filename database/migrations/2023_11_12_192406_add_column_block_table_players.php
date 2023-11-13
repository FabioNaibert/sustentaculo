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
        if (!Schema::hasColumn('players', 'active')) {
            Schema::table('players', function (Blueprint $table) {
                $table->boolean('active')->default(true);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('players', 'active')) {
            Schema::table('players', function (Blueprint $table) {
                $table->dropColumn('active');
            });
        }
    }
};