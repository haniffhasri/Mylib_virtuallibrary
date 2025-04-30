<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // Add polymorphic columns
            $table->unsignedBigInteger('commentable_id')->nullable()->after('user_id');
            $table->string('commentable_type')->nullable()->after('commentable_id');

            // Index for performance
            $table->index(['commentable_id', 'commentable_type']);

            // Temporarily keep book_id until data is migrated
        });

        // OPTIONAL: Migrate existing book comment data to polymorphic
        DB::table('comments')->whereNotNull('book_id')->update([
            'commentable_type' => 'App\\Models\\Book',
        ]);

        DB::statement('UPDATE comments SET commentable_id = book_id WHERE book_id IS NOT NULL');

        Schema::table('comments', function (Blueprint $table) {
            // Drop old book_id column after migration
            $table->dropForeign(['book_id']);
            $table->dropColumn('book_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->foreignId('book_id')->nullable()->constrained()->onDelete('cascade');
            $table->dropIndex(['commentable_id', 'commentable_type']);
            $table->dropColumn(['commentable_id', 'commentable_type']);
        });
    }
};
