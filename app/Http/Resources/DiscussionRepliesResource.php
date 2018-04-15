<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\User;
use App\DiscussionVotes;
use Carbon\Carbon;

class DiscussionRepliesResource extends Resource
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
            'parent_comment' => $this->parent_comment,
            'user_id' => User::find($this->user_id),
            'date' => $this->created_at->diffInDays(Carbon::now()) >= 1 ? $this->created_at->format('j M Y , g:ia') : $this->created_at->diffForHumans()
        ];
    }
}
