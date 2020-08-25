<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/welcome', 'welcome');

Route::group(['prefix' => 'tweets'], function () {
    Route::get('/', 'TweetController@tweets');
    Route::get('/{id}', 'TweetController@tweet');
    Route::post('/', 'TweetController@create');
    Route::delete('/{id}', 'TweetController@delete');
    Route::post('/{id}/like', 'TweetLikesController@store');
    Route::delete('/{id}/like', 'TweetLikesController@destroy');
});

Route::group(['prefix' => 'users'], function () {
    Route::get('/', 'UserController@users');
    Route::get('/{id}', 'UserController@user');
    Route::post('/', 'UserController@create');
    Route::put('/{id}', 'UserController@update');
    Route::delete('/{id}', 'UserController@delete');

});

Route::group(['prefix' => 'replies'], function () {
    Route::get('/', 'ReplyController@replies');
    Route::get('/{id}', 'ReplyController@reply');
    Route::post('/', 'ReplyController@create');
    Route::delete('/{id}', 'ReplyController@delete');
});
