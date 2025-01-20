<?php

namespace App\Services;

use App\Repositories\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login($request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $credentials = $validator->validated();
            $user = $this->authRepository->findUserByEmail($credentials['email']);

            if (!$user) {
                return ['status' => false, 'message' => 'Email is not registered'];
            } elseif (!Hash::check($credentials['password'], $user->password)) {
                return ['status' => false, 'message' => 'Password is incorrect'];
            }

            $token = $user->createToken('auth_token')->plainTextToken;
            request()->session()->regenerate();
            Auth::login($user);

            return ['status' => true, 'message' => 'Login success', 'token' => $token];
        } catch (ValidationException $e) {
            return ['status' => false, 'message' => 'Validation failed', 'errors' => $e->errors()];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => 'An error occurred during login', 'error' => $e->getMessage()];
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