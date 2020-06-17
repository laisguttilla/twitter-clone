<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reply extends Model
{
    use SoftDeletes;

    protected $table = 'replies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reply', 'user_id', 'tweet_id'
    ];

    /**
     * Tweet relationship
     *
     */
    public function tweet()
    {
        return $this->belongsTo('App\Tweet');
    }

    /**
     * User relationship
     *
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
