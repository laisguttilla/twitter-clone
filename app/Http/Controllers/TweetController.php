<?php

namespace App\Http\Controllers;

use App\Http\Requests\TweetRequest;
use App\Tweet;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TweetController extends Controller
{
    public function tweets()
    {
        try {

            return response()->json(Tweet::all(), 200);
        } catch (ModelNotFoundException $exception) {

            return response()->json([
                'message' => 'Tweets not found.'
            ], 404);
        } catch (Exception $exception) {

            return response()->json([
                'message' => 'Oops! Something went wrong.'
            ], 500);
        }
    }

    public function tweet(string $tweetID)
    {
        try {

            return response()->json(Tweet::findOrFail($tweetID), 200);
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
