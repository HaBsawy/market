<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ];
        }
        return response()->json($data, 200);
    }

    public function update(Request $request, User $user)
    {
        if (auth()->user()->role != 'admin') {
            return response()->json([
                'message' => 'you have not permission to update user'
            ], 403);
        }

        $this->validate($request, [
            'role' => 'required|in:admin,employee,customer'
        ]);

        $user->role = $request->role;

        if($user->save()) {
            return response()->json([
                'message' => 'user is updated successfully',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role
                ]
            ], 202);
        }
    }

    public function destroy(User $user)
    {
        if (auth()->user()->role != 'admin') {
            return response()->json([
                'message' => 'you have not permission to delete user'
            ], 403);
        }

        if($user->delete()) {
            return response()->json([
                'message' => 'user is deleted successfully'
            ], 200);
        }
    }
}
