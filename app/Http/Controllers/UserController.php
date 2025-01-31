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
    protected $userService;
    protected $roleService;
    protected $groupService;
    protected $fileUploadService;
    public function __construct(UserService $userService, RoleService $roleService, FileUploadServiceInterface $fileUploadService, GroupServiceInterface $groupService) // Constructor to inject the user service
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
        $this->groupService = $groupService;
        $this->fileUploadService = $fileUploadService;
    }
    // public function index(Request $request)
    public function index()
    {
        // $search = $request->input('search');
        // $pageSize = $request->input('pageSize', 5);

        // Ambil data pengguna dari UserService
        // $users = $this->userService->getAllUsers($pageSize, $search);
        $users = $this->userService->getAllUsers();

        // Tambahkan parameter query ke URL untuk pagination
        // $users->appends($request->only(['search', 'pageSize']));

        // return view('users.index', compact('users'));
        return response()->json(['users' => $users]);
    }

    // Menampilkan form untuk menambah pengguna
    public function create()
    {
        $roles = $this->roleService->getAllRoles();
        return view('users.create', compact('roles'));
    }

    // Menyimpan data pengguna
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $this->userService->createUser($data);
        // return redirect()->route('users.index')->with('status', 'User created successfully.');
        return response()->json(['message' => 'User created successfully.']);
    }

    // Menampilkan detail pengguna
    public function show($id)
    {
        $user = $this->userService->getUserById($id);
        $roles = $this->roleService->getAllRoles();
        $userRole = $roles->firstWhere('role_id', $user->role_id);

        // return view('users.show', compact('user', 'userRole'));
        return response()->json(['user' => $user, 'userRole' => $userRole]);
    }

    // Menampilkan form untuk mengedit pengguna
    public function edit($id)
    {
        $user = $this->userService->getUserById($id);
        $roles = $this->roleService->getAllRoles();
        // return view('users.edit', compact('user', 'roles'));
        return response()->json(['user' => $user, 'roles' => $roles]);
    }

    // Memperbarui data pengguna
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = $this->userService->getUserById($id);
            $data = $request->validated();

            if ($request->filled('current_password') && !Hash::check($request->current_password, $user->password)) {
                // return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
                throw new \Exception('Current password is incorrect.');
            }

            if ($request->hasFile('profile')) {
                if (!empty($user->profile)) {
                    $this->fileUploadService->deleteFile('user/profile/' . $user->profile);
                }
                $data['profile'] = $this->fileUploadService->uploadFile($request->file('profile'), 'user/profile/');
            }

            $this->userService->updateUser($id, $data);
            // return redirect()->route('users.index')->with('status', 'User updated successfully.');
            return response()->json(['message' => 'User updated successfully.']);
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors(['current_password' => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    // Menghapus pengguna
    public function destroy($id)
    {
        $this->userService->deleteUser($id);
        // return redirect()->route('users.index')->with('status', 'User deleted successfully.');
        return response()->json(['message' => 'User deleted successfully.']);
    }

    // Memperbarui role pengguna
    // public function updateUserRole(Request $request, $id)
    // {
    //     $request->validate([
    //         'role_id' => 'required|exists:roles,id',
    //     ]);

    //     $data = ['role_id' => $request->input('role_id')];
    //     $this->userService->updateUser($id, $data);

    //     return redirect()->route('users.index')->with('status', 'User role updated successfully.');
    // }

    // public function getUserGroups($userId)
    // {
    //     $groups = $this->groupService->getGroupsByUserId($userId);
    //     return response()->json($groups);
    // }
}
