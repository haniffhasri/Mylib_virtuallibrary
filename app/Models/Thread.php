<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = ['forum_id', 'user_id', 'title', 'body'];

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
