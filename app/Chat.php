<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mpociot\Firebase\SyncsWithFirebase;

class Chat extends Model
{
    use SyncsWithFirebase;
    protected $fillable = [
        'message',
        'user',
        'friend'
    ];
}

// \App\Chat::create([
//     'message' => 'test',
//     'user' => 1,
//     'friend' => 2
// ]);