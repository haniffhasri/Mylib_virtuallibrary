<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['name', 'username', 'email', 'password', 'profile_picture','bio','usertype','is_active'];

    public function borrow() {
        return $this->hasMany(Borrow::class);
    }
    public function visitor() {
        return $this->hasMany(Visitor::class);
    }
    public function comments() {
        return $this->hasMany(Comment::class);
    }
    public function ratings() {
        return $this->hasMany(Rating::class);
    }

    public function wishlists(){
        return $this->hasMany(Wishlist::class);
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
