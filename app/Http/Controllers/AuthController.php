<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    // Tampilkan formulir login
    // public function showLoginForm()
    // {
    //     return view('auth.login');
    // }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            // return redirect()->route('dashboard')->with('success', 'Login berhasil!');
            // return response()->json(['message' => 'Login berhasil!'], 200);
            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil!',
                'data' => [
                    'email' => $request->email,
                ]
            ], 200);
        }

        // return back()->withErrors(['email' => 'Email atau password salah.']);
        return response()->json(['message' => 'Email atau password salah.'], 401);
    }

    // Tampilkan formulir register
    // public function showRegistrationForm()
    // {
    //     return view('auth.register');
    // }

    // Proses registrasi
    // public function register(StoreUserRequest $request)
    // {
    //     // $data = $request->validated();
    //     $user = $this->userService->createUser($request->validated());

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Registrasi berhasil! Silakan login.',
    //         'data' => [
    //             'id' => $user->id,
    //             'name' => $user->name,
    //             'email' => $user->email,
    //         ]
    //     ], 201);
    // }


    // return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    // Proses logout
    public function logout()
    {
        Auth::logout();
        // return redirect()->route('login')->with('success', 'Logout berhasil.');
        return response()->json(['message' => 'Logout berhasil.'], 200);
    }
}
