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
        if (!Schema::hasColumn('chapters', 'title')) {
            Schema::table('chapters', function (Blueprint $table) {
                $table->text('title')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('chapters', 'title')) {
            Schema::table('chapters', function (Blueprint $table) {
                $table->dropColumn('title');
            });
        }
    }
};