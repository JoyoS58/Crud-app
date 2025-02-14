<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function getAllUsers($search = null)
    {
        $query = User::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%');
            });
        }

        return $query->get();
    }


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
        return $user->delete();
    }
    public function countUsers()
    {
        return User::count();
    }
}
