<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    protected $userService;
    protected $authService;

    public function __construct(UserService $userService, AuthService $authService)
    {
        $this->userService = $userService;
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        // Coba autentikasi user
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], true)) {
            $user = Auth::user();
            session()->regenerate(); // Regenerasi session untuk keamanan

            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil',
                'user' => $user
                
            ], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'Email atau password salah'], 401);
    }





    // Proses registrasi
    public function register(StoreUserRequest $request)
    {
        $user = $this->userService->createUser($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Registrasi berhasil! Silakan login.',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]
        ], 201);
    }

    // Proses logout
    public function logout(Request $request)
    {
        // Revoke the current user's token
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        // Logout the user
        Auth::guard('web')->logout();

        // Regenerate session to prevent fixation
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logout berhasil.'], 200);
    }
}
