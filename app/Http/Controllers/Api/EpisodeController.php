<?php

namespace App\Http\Controllers\Api;

use App\Episode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EpisodeResource;

class EpisodeController extends Controller
{
    // public function index()
    // {
    //     $episodes = Episode::latest()
    //         ->paginate(10);

    //     return ShowResource::collection($episodes);
    // }
    public function index($show, Request $request){
        $episodes = Episode::where('show_id', $show)
                    ->get();

        return  EpisodeResource::collection($episodes);
    }
}
