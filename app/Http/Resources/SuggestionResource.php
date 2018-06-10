<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Suggestion;
use App\Show;
use App\Http\Resources\ShowResource;

class SuggestionResource extends Resource
{
    public function toArray($request)
    {
        return [
            'suggestion' => Show::where('id', $this->suggestion)->get()
        ];
    }
}
