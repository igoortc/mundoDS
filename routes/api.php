<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('shows', 'Api\ShowController');
Route::resource('shows.episodes', 'Api\EpisodeController');
Route::resource('users.watches', 'Api\WatchController');
Route::resource('users', 'Api\UserController');
Route::resource('user.following', 'Api\UserFollowController');
Route::resource('user.followers', 'Api\FollowController');
Route::resource('episodes.discussion', 'Api\DiscussionController');
Route::get('chat/{user}/friend/{friend}', 'Api\ChatController@index');
Route::post('chat/{user}/friend/{friend}', 'Api\ChatController@store');
Route::put('not_spam/{discussion}', 'Api\DiscussionController@notSpam');
Route::delete('destroy_spam/{discussion}', 'Api\DiscussionController@destroySpam');