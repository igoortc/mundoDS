<?php

namespace App\Http\Controllers\Api;

use App\Episode;
use App\Show;
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
                    ->orderBy('number')
                    ->get();

        return  EpisodeResource::collection($episodes);
    }

    public function show(Show $show, Episode $episode)
    {
        return new EpisodeResource($episode);
    }

    public function store(Request $request)
    {
        $episode = $this->validate($request, [
            'id' => 'required|numeric',
            'name' => 'required|min:3|max:100',
            'show_id' => 'required',
            'season' => 'required|numeric',
            'number' => 'required|numeric',
            'synopsis' => 'nullable',
            'date_aired' => 'required',
            'image' => 'nullable|url'
        ]);

        $episode = Episode::create($episode);

        return new EpisodeResource($episode);
    }

    public function update(Request $request, $show, $episode)
    {
        $episode = Episode::find($episode);
        $episode->name = request('name');
        // $episode->show_id = request('show_id');
        $episode->season = request('season');
        $episode->number = request('number');
        $episode->synopsis = request('synopsis');
        // $episode->date_aired = request('date_aired');
        $episode->image = request('image');

        $episode->save();
        
        return response()->json([
            'message' => 'Episode updated successfully!'
        ], 200);
    }

    public function destroy($show, $id)
    {
        $episode = Episode::find($id);
        $episode->delete();

        return response()->json([
            'message' => 'Episode destroyed successfully!'
        ], 200);
    }
}
