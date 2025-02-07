<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use App\Models\User;
use App\Services\Contracts\FileUploadServiceInterface;
use App\Services\FileUploadService;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    protected $userService;
    protected $roleService;
    protected $fileUploadService;

    public function __construct(UserService $userService, RoleService $roleService, FileUploadServiceInterface $fileUploadService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
        $this->fileUploadService = $fileUploadService;
    }

    public function index(Request $request)
    {
        $count = $this->userService->countUsers();
        $search = $request->query('search', null);
        $users = $this->userService->getAllUsers($search);

        return response()->json(['users' => $users, 'count' => $count]);
    }

    public function create()
    {
        $roles = $this->roleService->getAllRoles();
        return response()->json(['roles' => $roles]);
    }
    public function store(StoreUserRequest $request)
    {
        try {
            $data = $request->validated();
            $result = $this->userService->createUser($data);

            return response()->json([
                'success' => $result['success'],
                'message' => $result['message'],
                'errors' => $result['errors'] ?? null,
            ], $result['success'] ? 201 : 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Show user by ID
    public function show($id)
    {
        $user = $this->userService->getUserById($id);
        $roles = $this->roleService->getAllRoles();
        $userRole = $roles->firstWhere('role_id', $user->role_id);

        return response()->json(['user' => $user, 'userRole' => $userRole]);
    }
    public function edit($id)
    {
        $user = $this->userService->getUserById($id);
        $roles = $this->roleService->getAllRoles();
        $userRole = $roles->firstWhere('role_id', $user->role_id);

        return response()->json(['user' => $user, 'userRole' => $userRole]);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = $this->userService->getUserById($id);
            if (!$user) {
                return response()->json(['message' => 'User not found.'], 404);
            }

            $data = $request->validated();

            if ($request->filled('current_password') && !Hash::check($request->current_password, $user->password)) {
                return response()->json(['message' => 'Current password is incorrect.'], 400);
            }

            if ($request->hasFile('profile')) {
                if (!empty($user->profile)) {
                    $this->fileUploadService->deleteFile('user/profile/' . $user->profile);
                }
                $data['profile'] = $this->fileUploadService->uploadFile($request->file('profile'), 'user/profile/');
            }

            $this->userService->updateUser($id, $data);
            return response()->json(['message' => 'User updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 400);
        }
    }


    // Menghapus pengguna
    public function destroy($id)
    {
        $result = $this->userService->deleteUser($id);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message']
        ], $result['success'] ? 200 : 404);
    }
}
