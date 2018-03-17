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

// URL::forceScheme('https');

Auth::routes();

Route::get('/', 'DashboardController@index')->middleware('auth');

Route::get('search/{search}', 'DashboardController@search');

Route::get('all_shows', 'ShowsController@index')->middleware('auth');
Route::get('all_users', 'UsersController@index')->middleware('auth');

Route::post('favorite/{show}', 'ShowsController@favoriteShow');
Route::post('unfavorite/{show}', 'ShowsController@unFavoriteShow');

Route::get('my_favorites', 'UsersController@myFavorites')->middleware('auth');

Route::get('my_watched', 'UsersController@myWatched')->middleware('auth');

Route::get('my_profile', 'UsersController@myProfile')->middleware('auth');

Route::get('following', 'UsersController@following')->middleware('auth');

Route::get('show/{show}/episode/{episode}', 'EpisodesController@show');

Route::get('show/{show}', 'ShowsController@show');

Route::get('user/{user}', 'UsersController@show');

Route::post('follow/{user}', 'UsersController@followUser');
Route::post('unfollow/{user}', 'UsersController@unfollowUser');

Route::get('average/{show}', 'ShowsController@average');

Route::get('avgEpisode/{episode}', 'EpisodesController@average');

Route::get('comments/{episode}', 'CommentController@index');

Route::post('comments', 'CommentController@store');

Route::post('comments/{commentId}/{type}', 'CommentController@update');

Route::get('dashFavorites/{user}', 'UsersController@dashFavorites');

Route::get('spam_comments', 'CommentController@getSpam');
Route::put('not_spam/{comment}', 'CommentController@notSpam');
Route::delete('destroy_spam/{comment}', 'CommentController@destroySpam');