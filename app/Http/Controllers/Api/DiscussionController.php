<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\DiscussionResource;
use App\Discussion;
use App\Episode;

class DiscussionController extends Controller
{
    public function index($episode, Request $request){
        $discussion = Discussion::where('episode_id', $episode)
                    ->where('parent_comment', 0)
                    ->orderBy('created_at','DESC')
                    ->get();

        return  DiscussionResource::collection($discussion);
    }

    public function show(Episode $episode, Discussion $discussion)
    {
        return new DiscussionResource($discussion);
    }

    public function destroy($episode, $id)
    {
        $discussion = Discussion::find($id);
        $discussion->delete();

        $replies = Discussion::where('parent_comment', $id);
        if ($replies) {
            $replies->delete();
        }

        return response()->json([
            'message' => 'Comment destroyed successfully!'
        ], 200);
    }

    public function update(Request $request, $episode, $discussion)
    {
        $discussion = Discussion::find($discussion);
        $discussion->update($request->all());
        
        return response()->json([
            'message' => 'Comment updated successfully!'
        ], 200);
    }

    public function store(Request $request)
    {
        $discussion = $this->validate($request, [
            'comment' => 'required',
            'votes' => 'required',
            'spam' => 'required',
            'reply_id' => 'required',
            'parent_comment' => 'nullable',
            'episode_id' => 'required',
            'user_id' => 'required'
        ]);

        $discussion = Discussion::create($discussion);

        return new DiscussionResource($discussion);
    }

    public function notSpam(Request $request, $id)
    {
        $discussion = Discussion::find($id);
        $discussion->spam = request('spam');
        $discussion->save();

        return response()->json([
            'message' => 'Comment unflagged successfully!'
        ], 200);
    }

    public function destroySpam(Request $request, $id)
    {
        $discussion = Discussion::find($id);
        $discussion->delete();

        return response()->json([
            'message' => 'Comment destroyed successfully!'
        ], 200);
    }
}
