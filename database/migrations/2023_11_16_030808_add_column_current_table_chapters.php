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
        if (!Schema::hasColumn('chapters', 'current')) {
            Schema::table('chapters', function (Blueprint $table) {
                $table->boolean('current')->default(false);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('chapters', 'current')) {
            Schema::table('chapters', function (Blueprint $table) {
                $table->dropColumn('current');
            });
        }
    }
};
