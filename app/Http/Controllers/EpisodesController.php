<?php

namespace App\Http\Controllers;

use App\Episode;
use App\Show;
use Illuminate\Http\Request;

class EpisodesController extends Controller
{
    // public function index(Show $show)
    // {
    //     $episodes = Episode::where('show_id', $show->id)
    //         ->paginate(5);

    //     return back();
    // }
    public function show(Show $show, Episode $episode)
    {
        $episode = Episode::where('id', $episode->id)
            ->first();
        return view('episodes.show', compact('episode'));
    }

    public function watchEpisode(Episode $episode)
    {
        Auth::user()->watches()->attach($episode->id);

        return back();
    }

    public function unwatchEpisode(Episode $episode)
    {
        Auth::user()->watches()->detach($episode->id);

        return back();
    }
}
