<?php

namespace App\Repositories;

use App\Models\Activity;
use App\Models\User;
use GuzzleHttp\Psr7\Request;

class AuthRepository implements AuthRepositoryInterface
{
    // Mendapatkan semua aktivitas
    public function login(Request $request)
    {
        
    }
    public function logout()
    {
        
    }
    public function findUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
