<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Discussion;
use App\DiscussionVotes;
use App\Http\Resources\DiscussionResource;
use App\Http\Resources\DiscussionVotesResource;

class DiscussionController extends Controller
{
    public function getSpams()
    {
        $spams = Discussion::where('spam', '1')
                ->get();

        return DiscussionResource::collection($spams);
    }

    public function loveDiscussion(Discussion $discussion)
    {
        Auth::user()->discussionLove()->attach($discussion->id);

        return back();
    }

    public function unloveDiscussion(Discussion $discussion)
    {
        Auth::user()->discussionLove()->detach($discussion->id);

        return back();
    }

    public function hasLoved ($user, $discussion) {
        $votes = DiscussionVotes::where('user_id', $user)
                ->where('comment_id', $discussion)
                ->first();
        if (empty($votes)) {
            return [];
        }
        return new DiscussionVotesResource($votes);
    }
}
