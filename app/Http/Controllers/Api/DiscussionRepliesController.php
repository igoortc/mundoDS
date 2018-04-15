<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DiscussionRepliesResource;
use App\Discussion;
use App\DiscussionReplies;


class DiscussionRepliesController extends Controller
{
    public function index($discussion, Request $request){
        $replies = DiscussionReplies::where('parent_comment', $discussion)
                    ->get();

        return  DiscussionRepliesResource::collection($replies);
    }

    public function show(Discussion $discussion, DiscussionReplies $discussionReplies)
    {
        return new DiscussionRepliesResource($discussionReplies);
    }

    public function destroy($discussion, $id)
    {
        $reply = DiscussionReplies::find($id);
        $reply->delete();

        return response()->json([
            'message' => 'Reply destroyed successfully!'
        ], 200);
    }

    public function update(Request $request, $discussion, $discussionReply)
    {
        $discussionReply = DiscussionReplies::find($discussion);

        $discussionReply->comment = request('comment');
        $discussionReply->votes = request('votes');
        $discussionReply->spam = request('spam');
        $discussionReply->parent_comment = request('parent_comment');
        $discussionReply->user_id = request('user_id');
        $discussionReply->save();
        
        return response()->json([
            'message' => 'Reply updated successfully!'
        ], 200);
    }

    public function store(Request $request)
    {
        $reply = $this->validate($request, [
            'comment' => 'required',
            'votes' => 'required',
            'spam' => 'required',
            'parent_comment' => 'required',
            'user_id' => 'required'
        ]);

        $reply = DiscussionReplies::create($reply);

        return new DiscussionRepliesResource($reply);
    }
}
