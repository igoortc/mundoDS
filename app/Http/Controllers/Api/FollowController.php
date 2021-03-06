<?php

namespace App\Http\Controllers\Api;

use App\Follow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FollowResource;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function index($user, Request $request){
        $followers = Follow::where('following_id', $user)
                    ->get();

        return  FollowResource::collection($followers);
    }

    public function store(Request $request)
    {
        $follow = $this->validate($request, [
            'user_id' => 'required',
            'following_id' => 'required'
        ]);

        $follow = Follow::create($follow);

        return response()->json([
            'follow'    => $follow,
            'message' => 'Success'
        ], 200);
    }

    public function destroy($user, $friendship_id)
    {
        $follow = Follow::find($friendship_id);
        $follow->delete();

        return response()->json([
            'message' => 'User unfollowed successfully!'
        ], 200);
    }
}
