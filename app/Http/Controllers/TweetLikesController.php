<?php

namespace App\Http\Controllers;

use App\Tweet;

class TweetLikesController extends Controller
{
    public function store(string $tweetID, string $userID)
    {
        $tweet = Tweet::findOrFail($tweetID);
        $tweet->like($userID);
    }
}
