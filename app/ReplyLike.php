<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReplyLike extends Model
{
    protected $table = 'reply_likes';
    protected $fillable = [
        'user_id', 'reply_id'
    ];

    public function reply()
    {
        return $this->belongsTo(Reply::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
