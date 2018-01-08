<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Follow;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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

}
