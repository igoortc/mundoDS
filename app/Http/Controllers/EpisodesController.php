<?php

namespace App\Http\Controllers;

use App\Episode;
use App\Show;
use App\Watch;
use Illuminate\Http\Request;

class EpisodesController extends Controller
{
    public function show(Show $show, Episode $episode)
    {
        $episode = Episode::where('id', $episode->id)
                ->first();
        return view('episodes.show', compact('episode'));
    }

    public function average($id) {
        $average = Watch::where('episode_id', $id)
                        ->avg('rating');
        $avg = number_format($average, 1, '.', ',');
        return $avg;

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
