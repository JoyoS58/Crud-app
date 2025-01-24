<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Data yang dikirim ke view, contoh:
        $usersCount = 120;
        $rolesCount = 10;
        $activities = [
            'Admin created a new role',
            'User John updated his profile',
            'Role Editor was deleted',
        ];

        return view('Homepage', compact('usersCount', 'rolesCount', 'activities'));
    }
}
