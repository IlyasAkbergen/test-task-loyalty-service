<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
        return response()->json([
            'user' => $user,
            'token' => $user->createToken('apiToken')->plainTextToken,
        ], 201);
    }

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = User::where('email', $request->get('email'))->first();

        if ($user && Hash::check($request->get('password'), $user->password)) {
            $token = $user->createToken($request->get('token_name', 'apiToken'))->plainTextToken;
        } else {
            return response()->json([
                'message' => __('Bad credentials'),
            ], 401);
        }

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->user()->tokens()->delete();
        return response()->json([ 'message' => __('Logged out') ]);
    }
}
