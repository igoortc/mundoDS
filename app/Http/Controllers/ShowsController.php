<?php

namespace App\Http\Controllers;

use App\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowsController extends Controller
{
    public function index()
    {
        $shows = Show::orderBy('name', 'ASC')->paginate(8);

        return view('shows.index', compact('shows'));
    }

    public function show(Show $show)
    {
        $show = Show::where('id', $show->id)
            ->first();
        return view('shows.show', compact('show'));
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
    
    public function average($id) {
        $show = Show::find($id);
        $episodes = DB::table('watches')
        ->join('episodes', 'watches.episode_id', '=', 'episodes.id')
        ->avg('watches.rating');

        return $episodes;
    }
}
