<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\User;
use App\Show;

class FavoritesResource extends Resource
{
    public function toArray($request)
    {
        return [
            'user' => User::find($this->user_id)
        ];
    }
}
