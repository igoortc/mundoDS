<?php

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

Route::get('/', 'ShowsController@index');

Route::post('favorite/{show}', 'ShowsController@favoriteShow');
Route::post('unfavorite/{show}', 'ShowsController@unFavoriteShow');

Route::get('my_favorites', 'UsersController@myFavorites')->middleware('auth');

Route::get('my_watched', 'UsersController@myWatched')->middleware('auth');

Route::get('my_profile', 'UsersController@myProfile')->middleware('auth');

Route::get('show/{show}/episode/{episode}', 'EpisodesController@show');

Route::get('show/{show}', 'ShowsController@show');

Route::get('user/{user}', 'UsersController@show');

Route::post('follow/{user}', 'UsersController@followUser');
Route::post('unfollow/{user}', 'UsersController@unfollowUser');

// Route::get('show/{show}/episodes', 'ShowsController@showEpisodes');
