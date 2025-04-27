<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['author','book_title','book_description','genre','format','status','book_publication_date','pdf_path','image_path'];
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    public function borrow() {
        return $this->hasMany(Borrow::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->with('replies.user', 'user');
    }
    
}
