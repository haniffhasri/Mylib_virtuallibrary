<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibrarianValidationCode extends Model
{
    protected $fillable = ['code', 'used'];
}
