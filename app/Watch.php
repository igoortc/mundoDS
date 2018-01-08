<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Watch extends Model
{
    protected $fillable = [
        'user_id', 'episode_id', 'rating',
    ];
    
    // public function belongsToEpisode()
    // {
    //     return $this->belongsTo('App\Episode');
    // }
}
