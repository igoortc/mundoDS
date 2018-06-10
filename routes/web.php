<?php

use Illuminate\Support\Facades\URL;
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

Auth::routes();

Route::get('/', 'DashboardController@index')->middleware('auth');

Route::get('search/{search}', 'DashboardController@search')->middleware('auth');

Route::get('all_shows', 'ShowsController@index')->middleware('auth');
Route::get('all_users', 'UsersController@index')->middleware('auth');

Route::post('favorite/{show}', 'ShowsController@favoriteShow');
Route::post('unfavorite/{show}', 'ShowsController@unFavoriteShow');
Route::get('fans/{show}', 'ShowsController@getFans');

Route::get('my_favorites', 'UsersController@myFavorites')->middleware('auth');
Route::get('my_watched', 'UsersController@myWatched')->middleware('auth');
Route::get('my_profile', 'UsersController@myProfile')->middleware('auth');
Route::get('following', 'UsersController@following')->middleware('auth');
Route::get('user_suggestions/{user}', 'UsersController@suggestions');

Route::get('show/{show}/episode/{episode}', 'EpisodesController@show')->middleware('auth');;

Route::get('show/{show}', 'ShowsController@show')->middleware('auth');;

Route::get('user/{user}', 'UsersController@show')->middleware('auth');;

Route::post('follow/{user}', 'UsersController@followUser');
Route::post('unfollow/{user}', 'UsersController@unfollowUser');

Route::get('average/{show}', 'ShowsController@average');

Route::get('avgEpisode/{episode}', 'EpisodesController@average');

Route::get('dashFavorites/{user}', 'UsersController@dashFavorites');

Route::get('spams', 'DiscussionController@getSpams');

Route::post('love_discussion/{discussion}', 'DiscussionController@loveDiscussion');
Route::post('unlove_discussion/{discussion}', 'DiscussionController@unloveDiscussion');

Route::get('user/{user}/discussion/{discussion}/hasLoved', 'DiscussionController@hasLoved');

Route::get('chat', 'UsersController@chat')->middleware('auth');