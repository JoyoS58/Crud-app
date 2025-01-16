<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUserToRoleRequest;
use App\Http\Requests\RemoveUserFromRoleRequest;
use App\Services\RoleServiceInterface;
use App\Services\UserServiceInterface;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;


class RoleController extends Controller
{
    protected $roleService;
    protected $userService;

    public function __construct(RoleServiceInterface $roleService, UserServiceInterface $userService)
    {
        $this->roleService = $roleService;
        $this->userService = $userService;
    }

    // Menampilkan semua roles
    public function index()
    {
        $roles = $this->roleService->getAllRoles();
        return view('roles.index', compact('roles'));
    }

    // Menampilkan form tambah role
    public function create()
    {
        return view('roles.create');
    }

    // Menyimpan role baru
    public function store(StoreRoleRequest $request)
    {
        $this->roleService->createRole($request->validated());
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    // Menampilkan detail role
    public function show($id)
    {
        $role = $this->roleService->getRoleById($id);
        $users = $this->userService->getAllUsers();
        return view('roles.show', compact('role', 'users'));
    }

    // Menampilkan form edit role
    public function edit($id)
    {
        $role = $this->roleService->getRoleById($id);
        return view('roles.edit', compact('role'));
    }

    // Mengupdate role
    public function update(UpdateRoleRequest $request, $id)
    {
        $this->roleService->updateRole($id, $request->validated());
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    // Menghapus role
    public function destroy($id)
    {
        $this->roleService->deleteRole($id);
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }

    // Menambahkan user ke role
    public function addUserToRole(AddUserToRoleRequest $request, $roleId)
    {
        
        try {
            $validated = $request->validated();
            $this->roleService->addUserToRole($roleId, $validated['userId']);

            return redirect()->route('roles.show', $roleId)->with('success', 'User added to role successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to add user to role: ' . $e->getMessage()]);
        }
    }

    // Menghapus user dari role
    public function removeUserFromRole(RemoveUserFromRoleRequest $request, $roleId)
    {
        $this->roleService->removeUserFromRole($roleId, $request->userId);
        return redirect()->route('roles.show', $roleId)->with('success', 'User removed from role successfully.');
    }
}
