<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $fillable = ['user_id', 'book_id', 'due_date', 'returned_at', 'is_active'];
    /** @use HasFactory<\Database\Factories\BorrowFactory> */
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function book() {
        return $this->belongsTo(Book::class);
    }
}
