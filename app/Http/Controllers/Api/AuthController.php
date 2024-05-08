<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * User register with token
     */
    public function register(UserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return response()->json([
            'data' => [
                'message' => 'Successfully',
                'access_token' => $token,
                'user' => $user,
            ]
        ]);
    }

    /**
     * User login
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($validated)) {
            return response()->json([
                'data' => 'Please check your password or email'
            ], 422);
        }

        $token = $request->user()->createToken('Personal Access Token')->plainTextToken;

        return response()->json([
           'data' => [
               'access_token' => $token,
               'user' => new UserResource(auth()->user()),
           ]
        ]);
    }

    /**
     * Logout function for auth user
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get user information about auth user
     */
    public function user()
    {
        return response()->json(new UserResource(auth()->user()));
    }
}
