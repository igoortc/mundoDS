<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\User;

class FollowResource extends Resource
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
            'user_id' => $this->user_id,
            'following_id' => $this->following_id,
            'user' => User::find($this->user_id),
            'following' => User::find($this->following_id),
            'date' => $this->created_at->diffForHumans()
        ];
    }
}
