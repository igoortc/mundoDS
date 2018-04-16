<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Carbon\Carbon;

class EpisodeResource extends Resource
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
            'show_id' => $this->show_id,
            'season' => $this->season,
            'number' => $this->number,
            'synopsis' => $this->synopsis,
            'date_aired' => $this->date_aired->diffInYears(Carbon::now()) >= 1 ? $this->date_aired->format('j M Y') : $this->date_aired->format('j M'),
            'image' => $this->image,
            'date' => $this->created_at->diffForHumans()
        ];
    }
}