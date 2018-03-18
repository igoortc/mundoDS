<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use App\Follow;
use App\Watch;

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

        $user->name = request('name');
        $user->photo = request('photo');
        $user->city = request('city');
        $user->bio = request('bio');
        $user->age = request('age');
        $user->admin = request('admin');
        $user->save();
        
        return response()->json([
            'message' => 'User updated successfully!'
        ], 200);
    }
}
