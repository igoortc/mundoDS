<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Watch;
use App\Http\Resources\WatchResource;

class WatchController extends Controller
{
    public function index($user, Request $request){
        $watches = Watch::where('user_id', $user)
                    ->get();

        return  WatchResource::collection($watches);
    }

    public function store(Request $request)
    {
        $watch = $this->validate($request, [
            'user_id' => 'required',
            'episode_id' => 'required',
            'rating' => 'required'
        ]);

        $watch = Watch::create($watch);

        return response()->json([
            'watch'    => $watch,
            'message' => 'Success'
        ], 200);
    }

    public function destroy($user, $watch_id)
    {
        $watch = Watch::find($watch_id);
        $watch->delete();

        return response()->json([
            'message' => 'Episode unwatched successfully!'
        ], 200);
    }

    public function update(Request $request, $user, $watch_id)
    {
        $watch = Watch::find($watch_id);
        $watch->update($request->all());

        return response()->json([
            'message' => 'Rating updated successfully!'
        ], 200);
    }
}