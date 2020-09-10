<?php

namespace App\Http\Controllers;

use App\Http\Requests\TweetRequest;
use App\Tweet;
use App\TweetLike;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    public function tweets()
    {
        try {
            $tweets = Tweet::with('replies')->get();
            if(!count($tweets)) {
                return response()->json('No tweets to display', 200);
            }

            return response()->json($tweets, 200);
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Oops! Something went wrong.'
            ], 500);
        }
    }

    public function tweet(string $tweetID)
    {
        try {
            $tweet = Tweet::with(['user','replies', 'replies.user', 'likes', 'likes.user'])->withCount(['replies', 'likes'])->find($tweetID);

            return response()->json($tweet, 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Tweet not found.'
            ], 404);
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Oops! Something went wrong.'
            ], 500);
        }
    }

    public function create(TweetRequest $request)
    {
        try {
            $tweet = Tweet::create([
                'user_id' => $request['user_id'],
                'tweet_text' => $request['tweet_text'],
            ]);

            return response()->json($tweet, 201);
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Oops! Something went wrong.'
            ], 500);
        }
    }

    public function like(string $tweetID, Request $request)
    {
        try {
            $tweet = Tweet::find($tweetID);

            return response()->json($tweet->likes()->create([
                'tweet_id' => $tweet->id,
                'user_id' => $request->user_id
            ], 201));
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Tweet not found.'
            ], 404);
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Oops! Something went wrong.'
            ], 500);
        }
    }

    public function dislike(string $tweetID, string $likeID)
    {
        try {
            $like = TweetLike::where('tweet_id', $tweetID)->where('id', $likeID)->first();
            $like->delete();

            return response()->json('Disliked successfully!');
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Like not found.'
            ], 404);
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Oops! Something went wrong.'
            ], 500);
        }
    }

    public function delete(string $tweetID)
    {
        try {
            $tweet = Tweet::findOrFail($tweetID);
            $tweet->delete();

            return response()->json('Tweet deleted successfully.', 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Tweet not found.'
            ], 404);
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Oops! Something went wrong.'
            ], 500);
        }
    }
}
