<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\Contracts\FileUploadServiceInterface;
use App\Services\FileUploadService;
use App\Models\User;
use App\Services\GroupServiceInterface;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

// use App\Services\FileUploadService;

class UserController extends Controller
{
    public function index()
    {
        // Return the view, but data will be fetched by AJAX
        return view('users.index');
    }

    public function create()
    {
        // Return view for creating a user
        return view('users.create');
    }

    public function show($id)
    {
        // Return view for showing a user, passing the ID
        return view('users.show');
    }

    public function edit($id)
    {
        // Return view for editing a user, data fetched by AJAX
        return view('users.edit');
    }
}
