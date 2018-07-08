<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mpociot\Firebase\SyncsWithFirebase;

class Watch extends Model
{
    use SyncsWithFirebase;
    protected $fillable = [
        'user_id', 'episode_id', 'rating',
    ];
    
    // public function belongsToEpisode()
    // {
    //     return $this->belongsTo('App\Episode');
    // }
}
