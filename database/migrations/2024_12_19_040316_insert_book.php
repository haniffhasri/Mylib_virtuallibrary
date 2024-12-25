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
        Schema::create("books", function (Blueprint $table) {
            $table->id();
            $table->string('author');
            $table->string('book_title');
            $table->text('book_description')->nullable();
            $table->string('genre');
            $table->string('format');
            $table->boolean('status');
            $table->date('book_publication_date');
            $table->string('pdf_path')->nullable(); // Path to the PDF file
            $table->string('image_path')->nullable(); // Path to the image file
            $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
