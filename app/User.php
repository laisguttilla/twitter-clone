<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Tweets relationship
     *
     */
    public function tweets()
    {
        return $this->hasMany('App\Tweet')->latest();
    }

    /**
     * Replies relationship
     *
     */
    public function replies()
    {
        return $this->hasMany('App\Reply');
    }

    /**
     * Likes relationship
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
