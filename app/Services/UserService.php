<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Services\UserServiceInterface;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers($search = null)
    {
        try {
            return $this->userRepository->getAllUsers($search);
        } catch (\Exception $e) {
            throw new \Exception('Failed to fetch users: ' . $e->getMessage());
        }
    }


    public function getUserById($id)
    {
        return $this->userRepository->getUserById($id);
    }

    public function createUser(array $data)
    {
        try {
            $user = $this->userRepository->createUser($data);

            return [
                'success' => true,
                'message' => 'User created successfully.',
                'data' => $user,
                'status' => 201 // Status Created
            ];
        } catch (Exception $e) {

            return [
                'success' => false,
                'message' => 'Failed to create user: ',
                'status' => 500 // Status Internal Server Error
            ];
        }
    }

    public function updateUser($id, array $data)
    {
        try {
            $user = $this->userRepository->getUserById($id);

            if (!$user) {
                throw new \Exception('User not found.');
            }

            // Jika password baru diisi, validasi current password dan hash password baru
            if (!empty($data['password'])) {
                if (!isset($data['current_password']) || !Hash::check($data['current_password'], $user->password)) {
                    throw new \Exception('Current password is incorrect.');
                }
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            // Hapus key 'current_password' agar tidak dimasukkan ke query update
            if (isset($data['current_password'])) {
                unset($data['current_password']);
            }

            return $this->userRepository->updateUser($id, $data);
        } catch (\Exception $e) {
            throw new \Exception('Failed to update user: ' . $e->getMessage());
        }
    }


    public function deleteUser($id)
    {
        try {
            $user = $this->userRepository->getUserById($id);

            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'User not found.'
                ];
            }

            $this->userRepository->deleteUser($id);

            return [
                'success' => true,
                'message' => 'User deleted successfully.'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to delete user: ' . $e->getMessage()
            ];
        }
    }


    public function validateUsers(array $userIds)
    {
        $validUsers = User::whereIn('id', $userIds)->get();

        if ($validUsers->count() != count($userIds)) {
            throw new \Exception("One or more users not found.");
        }
    }
    public function countUsers()
    {
        return $this->userRepository->countUsers();
    }
}
