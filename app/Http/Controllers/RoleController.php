<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUserToRoleRequest;
use App\Http\Requests\RemoveUserFromRoleRequest;
use App\Services\RoleServiceInterface;
use App\Services\UserServiceInterface;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Requests\UpdateUserFromRoleRequest;
use App\Models\User;

class RoleController extends Controller
{
    public function index()
    {
        return view('roles.index');
    }
    public function create()
    {
        return view('roles.create');
    }

    public function show($id)
    {
        return view('roles.show');
    }

    public function edit($id)
    {
        return view('roles.edit');
    }
}
