<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $request->validated();
        $user = User::create([
            'full_name' => $request->get('full_name'),
            'email' => $request->get('email'),
            'phone'=> $request->get('phone'),
            'password' => Hash::make($request->get('password')),
        ]);
        return response()->json([
           'success' => true,
           'data' => $user,
           'massage'=> 'user created successfully'
        ]);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where('phone', $data['phone'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid phone or password'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $user,
            'message' => 'Login successful',
              'token' => $token,
        ]);
    }


    public function me()
    {
        return response()->json([
            'success' => true,
            'user' => auth()->user(),
        ]);
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Logout successful'
        ]);
    }
}
