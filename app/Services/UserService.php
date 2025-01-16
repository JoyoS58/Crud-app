<?php
namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use App\Services\UserServiceInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAllUsers();
    }

    public function getUserById($id)
    {
        return $this->userRepository->getUserById($id);
    }

    public function createUser(array $data)
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $this->userRepository->createUser($data);
    }

    public function updateUser($id, array $data)
{
    // Ambil user yang sedang diupdate
    $user = $this->userRepository->getUserById($id);

    // If there's a new password and it's not empty, hash it
    if (isset($data['password']) && !empty($data['password'])) {
        $data['password'] = Hash::make($data['password']);
    } else {
        unset($data['password']); // Remove password if empty
    }

    return $this->userRepository->updateUser($id, $data);
}

    public function deleteUser($id)
    {
        return $this->userRepository->deleteUser($id);
    }

    public function validateUsers(array $userIds)
    {
        $validUsers = User::whereIn('id', $userIds)->get();

        if ($validUsers->count() != count($userIds)) {
            throw new \Exception("One or more users not found.");
        }
    }

    // Validasi untuk memastikan email unik
    private function validateEmailUnique($email, $userId)
    {
        $existingUser = User::where('email', $email)->where('user_id', '!=', $userId)->first();
        if ($existingUser) {
            throw new ValidationException("Email is already taken.");
        }
    }
    



}
