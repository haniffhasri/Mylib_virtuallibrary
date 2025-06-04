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
        Schema::table('search_logs', function (Blueprint $table) {
            $table->string('term')->nullable()->change();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique();
        });
        Schema::table('books', function (Blueprint $table) {
            $table->string('call_number')->unique();
            $table->string('item_id')->unique();
            $table->string('isbn');
            $table->string('initial_cataloguer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('search_logs', function (Blueprint $table) {
            $table->string('term')->nullable(false)->change();
        });
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }
        });
        Schema::table('books', function (Blueprint $table) {
            if (Schema::hasColumn('books', 'call_number')) {
                $table->dropColumn('call_number');
                $table->dropColumn('item_id');
                $table->dropColumn('isbn');
                $table->dropColumn('initial_cataloguer');
            }
        });

    }
};
