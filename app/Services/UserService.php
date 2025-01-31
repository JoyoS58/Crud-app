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

    // public function getAllUsers($perPage = 5, $search = null)
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
        return $this->userRepository->createUser($data);
    }
    public function updateUser($id, array $data)
    {
        $user = $this->userRepository->getUserById($id);

        // Validasi current password jika password baru diisi
        if (!empty($data['password'])) {
            if (!Hash::check($data['current_password'], $user->password)) {
                throw new \Exception('Current password is incorrect.');
            }

            // Hash password baru
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // Jangan update password jika kosong
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
    public function countUsers(){
        return $this->userRepository->countUsers();
    }
}
