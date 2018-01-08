<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()
            ->paginate(20);

        return UserResource::collection($users);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }
}
