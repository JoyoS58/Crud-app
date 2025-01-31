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
        // return view('roles.index', compact('roles'));
        return response()->json($roles);
    }

    // Menampilkan form tambah role
    // public function create()
    // {
    //     // return view('roles.create');
    // }

    // Menyimpan role baru
    public function store(StoreRoleRequest $request)
    {
        $this->roleService->createRole($request->validated());
        // return redirect()->route('roles.index')->with('success', 'Role created successfully.');
        return response()->json(['message' => 'Role created successfully']);
    }

    // Menampilkan detail role
    public function show($id)
    {
        $count = $this->userService->countUsers();
        $role = $this->roleService->getRoleById($id);
        $users = $this->userService->getAllUsers($count);
        // return view('roles.show', compact('role', 'users'));
        return response()->json($role);
    }

    // Menampilkan form edit role
    public function edit($id)
    {
        $count = $this->userService->countUsers();
        $users = $this->userService->getAllUsers($count);
        $role = $this->roleService->getRoleById($id);
        // return view('roles.edit', compact('role', 'users'));
        return response()->json($role);
    }

    // Mengupdate role
    public function update(UpdateRoleRequest $request, $id)
    {
        $this->roleService->updateRole($id, $request->validated());
        // return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
        return response()->json(['message' => 'Role updated successfully']);
    }

    // Menghapus role
    public function destroy($id)
    {
        $this->roleService->deleteRole($id);
        // return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
        return response()->json(['message' => 'Role deleted successfully']);
    }

    public function addUserToRole(AddUserToRoleRequest $request, $roleId)
    {
        try {
            // Validasi request
            $validated = $request->validated();

            // Tambahkan user ke role
            $this->roleService->addUserToRole($roleId, $validated['userId']);

            // Redirect dengan pesan sukses
            // return redirect()->route('roles.show', $roleId)->with('success', 'User added to role successfully.');
            return response()->json(['message' => 'User added to role successfully']);
        } catch (\Exception $e) {
            // Redirect dengan pesan error
            // return redirect()->back()->withErrors(['error' => 'Failed to add user to role: ' . $e->getMessage()]);
            return response()->json(['error' => 'Failed to add user to role: ' . $e->getMessage()]);
        }
    }

    public function updateUserRole(UpdateUserFromRoleRequest $request, $roleId)
{
    try {

        $validated = $request->validated();

        $this->roleService->updateUserRole($roleId, $validated['userId']);

        // return redirect()->route('roles.show', $roleId)
        //     ->with('success', 'User role updated successfully.');
        return response()->json(['message' => 'User role updated successfully']);
    } catch (\Exception $e) {
        // return redirect()->route('roles.show', $roleId)
        //     ->withErrors(['error' => 'Failed to update user role: ' . $e->getMessage()]);
        return response()->json(['error' => 'Failed to update user role: ' . $e->getMessage()]);
    }
}
}
