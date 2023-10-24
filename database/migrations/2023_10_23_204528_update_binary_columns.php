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
        if (Schema::hasColumn('images', 'content')) {
            Schema::table('images', function (Blueprint $table) {
                $table->string('content')->change();
            });
        }

        if (Schema::hasColumn('sounds', 'content')) {
            Schema::table('sounds', function (Blueprint $table) {
                $table->string('content')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('images', 'content')) {
            Schema::table('images', function (Blueprint $table) {
                $table->binary('content')->change();
            });
        }

        if (Schema::hasColumn('sounds', 'content')) {
            Schema::table('sounds', function (Blueprint $table) {
                $table->binary('content')->change();
            });
        }
    }
};
