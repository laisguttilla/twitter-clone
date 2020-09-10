<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TweetLike extends Model
{
    protected $table = 'tweet_likes';
    protected $fillable = [
        'user_id', 'tweet_id'
    ];

    public function tweet()
    {
        return $this->belongsTo(Tweet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
