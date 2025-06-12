<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Forum extends Model
{
    protected $fillable = ['forum_title', 'forum_description', 'slug', 'user_id'];

    protected static function booted()
    {
        static::creating(function ($forum) {
            $forum->slug = Str::slug($forum->forum_title);

            // Optional: make sure slug is unique
            $originalSlug = $forum->slug;
            $counter = 1;

            while (Forum::where('slug', $forum->slug)->exists()) {
                $forum->slug = $originalSlug . '-' . $counter++;
            }
        });

        static::deleting(function ($forum) {
            $forum->threads()->delete(); 
        });
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
