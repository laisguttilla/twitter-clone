<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tweet extends Model
{
    use SoftDeletes, Likeable;

    protected $guarded = [];

    protected $table = 'tweets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tweet_text', 'user_id'
    ];

    /**
     * User relationship
     *
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Replies relationship
     *
     */
    public function replies()
    {
        return $this->hasMany('App\Reply');
    }
}
