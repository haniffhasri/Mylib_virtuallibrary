<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $fillable = ['title', 'description', 'slug', 'user_id'];

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
