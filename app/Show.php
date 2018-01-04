<?php

namespace App;

use App\Favorite;
use Illuminate\Support\Facades\Auth;
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

    public function favorited()
    {
        return (bool) Favorite::where('user_id', Auth::id())
                            ->where('show_id', $this->id)
                            ->first();
    }
}
