<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\User;
use Carbon\Carbon;

class ChatResource extends Resource
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
            'message' => $this->message,
            'user' => User::find($this->user),
            'friend' => User::find($this->friend),
            'date' => $this->created_at->diffInDays(Carbon::now()) >= 1 ? $this->created_at->format('j M Y , g:ia') : $this->created_at->diffForHumans()
        ];
    }
}
