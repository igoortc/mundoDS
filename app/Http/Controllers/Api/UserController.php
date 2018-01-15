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

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json([
            'message' => 'User destroyed successfully!'
        ], 200);
    }

    public function update(Request $request, $user)
    {
        $user = User::find($user);
        $user = $this->validate($request, [
            'name' => 'required|min:3|max:100',
            'password' => 'required',
            'photo' => 'required',
            'city' => 'required',
            'bio' => 'required'
        ]);
        $user->save();
        
        return response()->json([
            'message' => 'User updated successfully!'
        ], 200);
    }
}
