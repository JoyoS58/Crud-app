<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddUserToRoleRequest;
use App\Services\RoleServiceInterface;
use App\Services\UserServiceInterface;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Requests\UpdateUserFromRoleRequest;
use App\Services\RoleService;

class RoleApiController extends Controller
{
    protected $roleService;
    protected $userService;

    public function __construct(RoleService $roleService, UserServiceInterface $userService)
    {
        $this->roleService = $roleService;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $search = $request->query('search', null);
        $roles = $this->roleService->getAllRoles($search);

        return response()->json(['roles' => $roles]);
    }

    // Menyimpan role baru
    public function store(StoreRoleRequest $request)
    {
        $this->roleService->createRole($request->validated());
        return response()->json(['message' => 'Role created successfully']);
    }

    // Menampilkan detail role
    public function show($id)
    {
        // $count = $this->userService->countUsers();
        $role = $this->roleService->getRoleById($id);
        $users = $this->userService->getAllUsers();
        return response()->json(['role' => $role, 'users' => $users]);
    }

    // Menampilkan form edit role
    public function edit($id)
    {
        try {
            $role = $this->roleService->getRoleById($id);
            if (!$role) {
                return response()->json(['message' => 'Role not found.'], 404);
            }
            // Jika diperlukan, tambahkan data tambahan (misalnya, permissions, atau data terkait lainnya)
            return response()->json(['role' => $role]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 400);
        }
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        try {
            $role = $this->roleService->getRoleById($id);
            if (!$role) {
                return response()->json(['message' => 'Role not found.'], 404);
            }

            $data = $request->validated();

            $this->roleService->updateRole($id, $data);
            return response()->json(['message' => 'Role updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 400);
        }
    }

    // Menghapus role
    public function destroy($id)
    {
        $result = $this->roleService->deleteRole($id);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message']
        ], $result['success'] ? 200 : 404);
    }

    public function addUserToRole(AddUserToRoleRequest $request, $roleId)
    {
        try {
            // Validasi request
            $validated = $request->validated();

            // Tambahkan user ke role
            $this->roleService->addUserToRole($roleId, $validated['userId']);

            // Redirect dengan pesan sukses
            return response()->json(['message' => 'User added to role successfully']);
        } catch (\Exception $e) {
            // Redirect dengan pesan error
            return response()->json(['error' => 'Failed to add user to role: ' . $e->getMessage()]);
        }
    }

    public function updateUserRole(UpdateUserFromRoleRequest $request, $roleId)
    {
        try {

            $validated = $request->validated();

            $this->roleService->updateUserRole($roleId, $validated['userId']);

            // return redirect()->route('roles.show', $roleId)
            return response()->json(['message' => 'User role updated successfully']);
        } catch (\Exception $e) {
            // return redirect()->route('roles.show', $roleId)
            return response()->json(['error' => 'Failed to update user role: ' . $e->getMessage()]);
        }
    }
}
