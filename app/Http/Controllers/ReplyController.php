<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Reply;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function replies()
    {
        try {
            $tweets = Reply::all();
            if(!count($tweets)) {
                return response()->json('No replies to display', 200);
            }

            return response()->json($tweets, 200);
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Oops! Something went wrong.'
            ], 500);
        }
    }

    public function reply(string $replyID)
    {
        try {
            $reply = Reply::with('user', 'tweet', 'tweet.user', 'likes')->withCount(['likes'])->find($replyID);
            return response()->json($reply, 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Reply not found.'
            ], 404);
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Oops! Something went wrong.'
            ], 500);
        }
    }

    public function create(ReplyRequest $request)
    {
        try {
            $tweet = Reply::create([
                'reply' => $request['reply'],
                'user_id' => $request['user_id'],
                'tweet_id' => $request['tweet_id'],
            ]);

            return response()->json($tweet, 201);
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Oops! Something went wrong.'
            ], 500);
        }
    }

    public function like(string $replyID, Request $request)
    {
        try {
            $reply = Reply::find($replyID);

            return response()->json($reply->likes()->create([
                'reply_id' => $reply->id,
                'user_id' => $request->user_id
            ], 201));
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Reply not found.'
            ], 404);
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Oops! Something went wrong.'
            ], 500);
        }
    }

    public function delete(string $replyID)
    {
        try {
            $reply = Reply::findOrFail($replyID);
            $reply->delete();

            return response()->json('Reply deleted successfully.', 200);
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
