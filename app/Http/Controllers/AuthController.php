<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Helpers\ResponseHelper;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Register a new user
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role ?? 'author',
            ]);

            return ResponseHelper::success($user, 'User registered successfully', 201);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), 500);
        }
    }

    // Login user
    public function login(LoginRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return ResponseHelper::error('Invalid credentials', 401);
            }
            $user->tokens()->delete();
            $token = $user->createToken('Login Token')->plainTextToken;
            return ResponseHelper::success([
                'user' => $user,
                'token' => $token
            ], 'User logged in successfully', 200);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), 500);
        }
    }
    
    // Logout user
    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->where('id', $request->user()->currentAccessToken()->id)->delete();
            return ResponseHelper::success(null, 'User logged out successfully', 200);
        } catch (\Exception $e) {
            return ResponseHelper::error('Something went wrong while logging out', 500);
        }
    }
}
