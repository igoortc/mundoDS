<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ShowResource extends Resource
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
            'name' => $this->name,
            'poster' => $this->poster,
            'synopsis' => $this->synopsis,
            'seasons' => $this->seasons,
            'status' => $this->status,
            'netflix' => $this->netflix,
            'imdb' => $this->imdb,
            'date' => $this->created_at->diffForHumans()
        ];
    }
}
