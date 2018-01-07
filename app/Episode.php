<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Watch;
use App\Show;

class Episode extends Model
{
    protected $fillable = [
        'name',
        'show_id',
        'season',
        'number',
        'synopsis',
        'image',
        'date_aired',
    ];

    public function watched() {
        return (bool) Watch::where('user_id', Auth::id())
                            ->where('episode_id', $this->id)
                            ->first();
    }

    public function average() {
        $average = Watch::where('episode_id', $this->id)
                        ->avg('rating');
        
        return $average;

    }

    public function getShow($id) {
        $show = Show::find($id);

        return $show->name;
    }
}