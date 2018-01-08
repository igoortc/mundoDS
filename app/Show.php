<?php

namespace App;

use App\Favorite;
use App\Watch;
use App\Episode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    /**
     * Fields that are mass assignable
     * @var array
     */
    protected $fillable = [
        'name',
        'poster',
        'synopsis',
        'seasons',
        'status',
        'netflix',
        'imdb',
    ];

    public function favorited() {
        return (bool) Favorite::where('user_id', Auth::id())
                            ->where('show_id', $this->id)
                            ->first();
    }

    public function getAverage($id) {
        $show = Show::find($id);
        $average = DB::table('watches')
        ->join('episodes', 'watches.episode_id', '=', 'episodes.id')
        ->avg('watches.rating');
        $avg = number_format($average, 1, '.', ',');

        return $avg;
    }

    // public function episodes()
    // {
    //     return $this->hasMany('App\Episode');
    // }

}
