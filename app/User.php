<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Follow;
use App\Watch;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'photo', 'age', 'city', 'bio', 'admin'
    ];

    protected $dates = [
        'age'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'admin',
    ];

    public function favorites()
    {
        return $this->belongsToMany(Show::class, 'favorites', 'user_id', 'show_id')->withTimeStamps();
    }

    public function watches()
    {
        return $this->belongsToMany(Episode::class, 'watches', 'user_id', 'episode_id')->withTimeStamps();
    }

    public function follows()
	{
		return $this->belongsToMany(User::class, 'follows', 'user_id', 'following_id')->withTimeStamps();
    }
    
    public function followed() {
        return (bool) Follow::where('user_id', Auth::id())
                            ->where('following_id', $this->id)
                            ->first();
    }

    public function nrEpisodes($id) {
        return Watch::where('user_id', $id)
                    ->count();
    }

    public function nrRatings($id) {
        return Watch::where('user_id', $id)
                    ->where('rating', '<>', '0')
                    ->count();
    }

    public function areFriends($id) {
        //
    }

    public function discussionLove()
    {
        return $this->belongsToMany(Discussion::class, 'discussion_votes', 'user_id', 'comment_id')->withTimeStamps();
    }

}
