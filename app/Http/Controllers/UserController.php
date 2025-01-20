<?php
namespace App\Http\Controllers;
use App\Services\UserService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService) // Constructor to inject the user service
    {
        $this->userService = $userService;
    }
    // Menampilkan daftar pengguna
    public function index()
    {
        $users = $this->userService->getAllUsers(); // Get all users
        return view('users.index', compact('users')); // Return the view with users
    }

    // Menampilkan form untuk menambah pengguna
    public function create()
    {
        return view('users.create');
    }

    // Menyimpan data pengguna
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $this->userService->createUser($data);
        return redirect()->route('users.index')->with('status', 'User created successfully.');
    }

    // Menampilkan detail pengguna
    public function show($id)
    {
        $user = $this->userService->getUserById($id);
        return view('users.show', compact('user'));
    }

    // Menampilkan form untuk mengedit pengguna
    public function edit($id)
    {
        $user = $this->userService->getUserById($id);
        return view('users.edit', compact('user'));
    }

    // Memperbarui data pengguna
    public function update(UpdateUserRequest $request, $id)
    {
        $data = $request->validated();

        try {
            $this->userService->updateUser($id, $data);
            return redirect()->route('users.index')->with('status', 'User updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['current_password' => $e->getMessage()]);
        }
    }


    // Menghapus pengguna
    public function destroy($id)
    {
        $this->userService->deleteUser($id);
        return redirect()->route('users.index')->with('status', 'User deleted successfully.');
    }
}
