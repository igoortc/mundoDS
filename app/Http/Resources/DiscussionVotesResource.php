<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class DiscussionVotesResource extends Resource
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
            'user_id' => $this->user_id,
            'comment_id' => $this->comment_id
        ];
    }
}
