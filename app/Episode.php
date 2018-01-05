<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Watch;

class Episode extends Model
{
    public function watched()
    {
        return (bool) Watch::where('user_id', Auth::id())
                            ->where('episode_id', $this->id)
                            ->first();
    }
}
