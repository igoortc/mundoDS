<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscussionReplies extends Model
{
    protected $fillable = [
        'comment',
        'votes',
        'spam',
        'parent_comment',
        'user_id'
    ];
}
