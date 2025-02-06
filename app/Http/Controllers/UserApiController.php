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

    // Fetch all users
    public function index()
    {
        $users = $this->userService->getAllUsers();
        return response()->json(['users' => $users]);
    }
    public function create()
    {
        $roles = $this->roleService->getAllRoles();
        return response()->json(['roles' => $roles]);
    }
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $this->userService->createUser($data);
        return response()->json(['message' => 'User created successfully.']);
    }

    // Show user by ID
    public function show($id)
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
            $data = $request->validated();

            if ($request->filled('current_password') && !Hash::check($request->current_password, $user->password)) {
                throw new \Exception('Current password is incorrect.');
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
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    // Menghapus pengguna
    public function destroy($id)
    {
        $this->userService->deleteUser($id);
        return response()->json(['message' => 'User deleted successfully.']);
    }
}
