<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\User;
use App\Episode;
use App\DiscussionVotes;
use App\DiscussionReplies;
use App\Http\Resources\UserResource;
use App\Http\Resources\DiscussionRepliesResource;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DiscussionResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'votes' => DiscussionVotes::where('comment_id', $this->id)->count(),
            'spam' => $this->spam,
            'reply_id' => DiscussionRepliesResource::collection(DiscussionReplies::where('parent_comment', $this->id)->get()),
            'episode_id' => Episode::find($this->episode_id),
            'user_id' => User::find($this->user_id),
            'date' => $this->created_at->diffInDays(Carbon::now()) >= 1 ? $this->created_at->format('j M Y , g:ia') : $this->created_at->diffForHumans()
        ];
    }
}