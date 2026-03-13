<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // VIEW PROFILE [GET] (Return authenticated user details)
    public function view_profile()
    {
        return response()->json([
            'message' => 'User details',
            'name' => auth()->user()->name,
            'email' => auth()->user()->email
        ], 200);
    }

    // UPDATE PROFILE [PATCH] (Update name or email)
    public function update_profile(Request $request)
    {

        $request->validate([
            'name' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:users,email,' . auth()->user()->id,
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response()->json([
            'message' => 'User details updated successfully',
            'name' => $user->name,
            'email' => $user->email
        ], 200);
    }

    // DELETE PROFILE [DELETE] (Delete user account)
    public function delete_profile()
    {
        auth()->user()->delete();
        return response()->json(['message' => 'User account deleted successfully'], 204);
    }
}
