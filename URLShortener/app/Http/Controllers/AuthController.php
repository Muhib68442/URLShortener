<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // REGISTER [GET]
    public function register()
    {
        return response()->json(['message' => 'Welcome to URLShortener. Please Register with name, email and password'], 200);
    }

    // REGISTER [POST]
    public function register_post(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // GENERATE TOKEN 
        $token = $user->createToken('auth_token')->plainTextToken;

        \Log::info('User Registered Successfully', []);

        if ($user && $token) {
            return response()->json([
                'message' => 'User registered successfully',
                'token' => $token
            ], 201);
        } else {
            return response()->json(['message' => 'Something went wrong. Please try again.'], 500);
        }
    }

    // LOGIN [GET]
    public function login()
    {
        return response()->json(['message' => 'Welcome to URLShortener. Please Login with email and password'], 200);
    }

    // LOGIN [POST] 
    public function login_post(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'User logged in successfully',
                'token' => $token
            ], 200);
        } else {
            return response()->json([
                'message' => 'Invalid email or password'
            ], 401);
        }
    }

    // CHECK [GET]
    public function check(Request $request)
    {
        return response()->json(['message' => 'Authenticated', 'token' => $request->bearerToken()], 200);
    }

    // LOGOUT [GET]
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'User logged out successfully'], 204);
        // Note: 204 prevents returning any data/message
    }
}
