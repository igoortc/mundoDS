<?php

namespace App\Http\Controllers\Api;

use App\Show;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShowResource;
use Illuminate\Support\Facades\Auth;

class ShowController extends Controller
{
    public function index()
    {
        $shows = Show::latest()
            ->paginate(3);

        return ShowResource::collection($shows);
    }

    public function show(Show $show)
    {
        return new ShowResource($show);
    }

    public function store(Request $request)
    {
        $show = $this->validate($request, [
            'name' => 'required|min:3|max:100',
            'poster' => 'required|url',
            'synopsis' => 'required|min:10',
            'seasons' => 'required|numeric',
            'status' => 'required',
            'netflix' => 'nullable|url',
            'imdb' => 'nullable|url'
        ]);

        $show = Show::create($show);

        return new ShowResource($show);
    }

    public function destroy($id)
    {
        $show = Show::find($id);
        $show->delete();

        return response()->json([
            'message' => 'Show destroyed successfully!'
        ], 200);
    }

    public function update(Request $request, $show)
    {
        $show = Show::find($show);
        $show->name = request('name');
        $show->poster = request('poster');
        $show->synopsis = request('synopsis');
        $show->seasons = request('seasons');
        $show->status = request('status');
        $show->netflix = request('netflix');
        $show->imdb = request('imdb');

        $show->save();
        
        return response()->json([
            'message' => 'Show updated successfully!'
        ], 200);
    }
}