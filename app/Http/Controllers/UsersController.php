<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Show;
use App\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(15);

        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user = User::where('id', $user->id)
            ->first();
        return view('users.show', compact('user'));
    }

    public function myFavorites()
    {
        $myFavorites = Auth::user()->favorites;

        return view('users.my_favorites', compact('myFavorites'));
    }

    public function dashFavorites($id)
    {
        $myFavorites = User::find($id)->favorites;

        return $myFavorites;
    }

    public function myWatched()
    {
        $myWatched = Auth::user()->watches;
        return view('users.my_watched', compact('myWatched'));
    }

    public function myProfile()
    {
        $myProfile = Auth::user();

        return view('users.my_profile', compact('myProfile'));
    }

    public function following()
    {
        $following = Auth::user()->follows;

        return view('users.following', compact('following'));
    }

    public function followUser(User $user)
    {
        Auth::user()->follows()->attach($user->id);

        return back();
    }

    public function unfollowUser(User $user)
    {
        Auth::user()->follows()->detach($user->id);

        return back();
    }
}
