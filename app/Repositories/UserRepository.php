<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    // public function getAllUsers($perPage = 5, $search = null)
    public function getAllUsers()
    {
        return User::all();
    }
    // {
    //     $query = User::query();

    //     if ($search) {
    //         $query->where(function ($q) use ($search) {
    //             $q->where('name', 'like', '%' . $search . '%')
    //                 ->orWhere('email', 'like', '%' . $search . '%');
    //         });
    //     }

    //     return $query->paginate($perPage);
    // }

    public function getUserById($id)
    {
        return User::findOrFail($id);
    }

    public function createUser(array $data)
    {
        return User::create($data);
    }

    public function updateUser($id, array $data)
    {
        $user = $this->getUserById($id);
        return $user->update($data);
    }

    public function deleteUser($id)
    {
        $user = $this->getUserById($id);
        $user->delete();
    }
    public function countUsers()
    {
        return User::count();
    }
}