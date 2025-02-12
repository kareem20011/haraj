<?php

namespace App\Http\Controllers\api\auth;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthanticationController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            $token = $user->createToken($user->name . 'auth-token')->plainTextToken;

            return response()->json([
                'message' => 'Registeration successful',
                'token_type' => 'Bearer',
                'token' => $token
            ], 201);
        } else {
            return response()->json([
                'message' => 'Somethink wend wrong!',
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'The provided credentails are incorrect'
            ], 401);
        }

        $token = $user->createToken($user->name . 'auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token_type' => 'Bearer',
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = User::find($request->user()->id);
        if ($user) {
            $user->tokens()->delete();
            return response()->json([
                'message' => 'Logged out successfuly.'
            ], 200);
        } else {
            return response()->json([
                'message' => 'User not found!'
            ], 404);
        }
    }
}
