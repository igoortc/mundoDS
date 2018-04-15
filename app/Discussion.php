<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DiscussionVotes;

class Discussion extends Model
{
    protected $fillable = [
        'comment',
        'votes',
        'spam',
        'reply_id',
        'parent_comment',
        'episode_id',
        'user_id'
    ];
}
