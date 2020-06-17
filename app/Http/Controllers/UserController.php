<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function users()
    {
        try {
            $users = User::all();
            if(!count($users)) {
                return response()->json('No users to display.', 200);
            }

            return response()->json($users, 200);
        }  catch (Exception $exception) {
            return response()->json([
                'message' => 'Oops! Something went wrong.'
            ], 500);
        }
    }

    public function user(string $userID)
    {
        try {
            return response()->json(User::findOrFail($userID), 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Oops! Something went wrong.'
            ], 500);
        }
    }

    public function create(UserRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'username' => $request['username']
            ]);

            return response()->json($user, 201);
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Oops! Something went wrong.'
            ], 500);
        }
    }

    public function update(UserRequest $request, string $userID)
    {
        try {
            $user = User::find($userID);
            $user->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'username' => $request['username']
            ]);

            return response()->json($user, 201);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Oops! Something went wrong.'
            ], 500);
        }
    }

    public function delete(string $userID)
    {
        try {
            $user = User::findOrFail($userID);
            $user->delete();

            return response()->json('User deleted successfully.', 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Oops! Something went wrong.'
            ], 500);
        }
    }
}
