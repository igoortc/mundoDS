<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class WatchResource extends Resource
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
            'episode_id' => $this->episode_id,
            'rating' => $this->rating,
            'date' => $this->created_at->diffForHumans()
        ];
    }
}