<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Chat;
use App\Http\Resources\ChatResource;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function index(Request $request, $user, $friend) {
        $chats = Chat::where(function ($query) use ($user) {
                        $query->where('user', $user)
                              ->orWhere('friend', $user);
                    })->where(function ($query) use ($friend) {
                        $query->where('user', $friend)
                              ->orWhere('friend', $friend);
                    })
                    ->get();
        return  ChatResource::collection($chats);
    }

    public function store(Request $request) {
        $chat = $this->validate($request, [
            'message' => 'required',
            'user' => 'required',
            'friend' => 'required'
        ]);

        $chat = Chat::create($chat);
        // broadcast(new MessageSent($chat))->toOthers();

        return ['status' => 'Message Sent!'];
    }
}
