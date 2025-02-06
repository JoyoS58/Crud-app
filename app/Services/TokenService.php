<?php
// app/Services/TokenService.php
namespace App\Services;

use App\Models\User;

class TokenService
{
    public function createToken(User $user): string
    {
        return $user->createToken('auth_token')->plainTextToken;
    }
}
