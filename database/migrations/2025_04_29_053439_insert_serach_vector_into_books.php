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
        DB::statement('ALTER TABLE books ADD COLUMN search_vector tsvector');

        DB::statement('CREATE INDEX books_search_vector_idx ON books USING GIN(search_vector)');

        DB::unprepared("
            CREATE FUNCTION update_search_vector() RETURNS trigger AS $$
            begin
                new.search_vector := 
                    to_tsvector('english', 
                        coalesce(new.book_title, '') || ' ' || coalesce(new.book_description, '')
                    );
                return new;
            end
            $$ LANGUAGE plpgsql;
        ");

        DB::unprepared("
            CREATE TRIGGER trigger_update_books_search_vector
            BEFORE INSERT OR UPDATE ON books
            FOR EACH ROW EXECUTE FUNCTION update_search_vector();
        ");

        DB::statement("UPDATE books SET search_vector = to_tsvector('simple', coalesce(book_title, '') || ' ' || coalesce(book_description, ''))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP TRIGGER IF EXISTS trigger_update_books_search_vector ON books');
        DB::statement('DROP FUNCTION IF EXISTS update_search_vector');
        DB::statement('DROP INDEX IF EXISTS books_search_vector_idx');
        DB::statement('ALTER TABLE books DROP COLUMN IF EXISTS search_vector');
    }
};
