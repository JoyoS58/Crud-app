<?php

namespace App\Services;

use App\Repositories\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }
    public function getUserByEmail(string $email)
    {
        return $this->authRepository->findUserByEmail($email);
    }

    public function login($request): array
    {
        try {
            $validator = Validator::make($request->all(), $request->rules());
            $credentials = $validator->validated();
            $email = $credentials['email'];
            $password = $credentials['password'];

            // Find user by email
            $user = $this->authRepository->findUserByEmail($email);

            // Check if user exists and password is correct
            if ($user && Hash::check($password, $user->password)) {
            $token = $user->createToken('auth_token')->plainTextToken;
            session()->regenerate();
            Auth::login($user);

            return [
                'status' => 200,
                'message' => 'Login berhasil!',
                'data' => [
                'email' => $user->email,
                'token' => $token,
                'user' => $user
                ]
            ];
            }
            // Return failure message if login fails
            return [
            'status' => 400,
            'message' => 'Email atau password salah.',
            ];
        } catch (ValidationException $e) {
            return [
            'status' => 400,
            'message' => 'Validasi gagal.',
            'errors' => $e->errors(),
            ];
        } catch (\Exception $e) {
            Log::error('Login failed: ' . $e->getMessage());
            return [
            'status' => 500,
            'message' => 'Terjadi kesalahan saat login.',
            'error' => $e->getMessage(),
            ];
        }
    }


    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return ['status' => true, 'message' => 'Logout success'];
    }
}
