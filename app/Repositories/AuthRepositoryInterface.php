<?php

namespace App\Repositories;

use App\Models\User;
use GuzzleHttp\Psr7\Request;

interface AuthRepositoryInterface
{
    public function login(Request $request);
    // public function register(Request $request);
    public function logout();
    public function findUserByEmail(string $email): ?User;
}