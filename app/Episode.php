<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Watch;
use App\Show;

class Episode extends Model
{
    protected $fillable = [
        'id',
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
        $avg = number_format($average, 1, '.', ',');
        return $avg;

    }

    public function getShow($id) {
        $show = Show::find($id);

        return $show->name;
    }

    // public function belongsToShow()
    // {
    //     return $this->belongsTo('App\Show');
    // }

    // public function episodeWatches()
    // {
    //     return $this->hasMany('App\Watch');
    // }

}