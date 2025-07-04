<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['author','book_title','book_description','genre','format','status','book_publication_date','media_path','image_path','call_number','item_id','isbn'];
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    public function borrow() {
        return $this->hasMany(Borrow::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id')->with('replies.user');
    }    

    public function allComments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function ratings() {
        return $this->hasMany(Rating::class);
    }

    public function averageRating() {
        return $this->ratings()->avg('rating');
    }
}
