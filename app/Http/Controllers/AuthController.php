<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Tampilkan formulir login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Tampilkan formulir register
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
}
