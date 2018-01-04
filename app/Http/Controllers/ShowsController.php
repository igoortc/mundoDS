<?php

namespace App\Http\Controllers;

use App\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShowsController extends Controller
{
    public function index()
    {
        $shows = Show::paginate(5);

        return view('shows.index', compact('shows'));
    }

    /**
     * Favorite a particular Show
     *
     * @param  Show $show
     * @return Response
     */
    public function favoriteShow(Show $show)
    {
        Auth::user()->favorites()->attach($show->id);

        return back();
    }

    /**
     * Unfavorite a particular show
     *
     * @param  Show $show
     * @return Response
     */
    public function unFavoriteShow(Show $show)
    {
        Auth::user()->favorites()->detach($show->id);

        return back();
    }
}
