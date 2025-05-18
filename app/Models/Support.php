<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $fillable = ['support_title', 'content', 'support_type'];

    const TYPE_FAQ = 'faq';
    const TYPE_VIDEO = 'embedded_video';
}

