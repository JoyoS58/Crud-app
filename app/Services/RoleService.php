<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\RoleRepositoryInterface;
use Illuminate\Support\Facades\Log;

class RoleService implements RoleServiceInterface
{
    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getAllRoles()
    {
        return $this->roleRepository->getAllRoles();
    }

    public function getRoleById($id)
    {
        return $this->roleRepository->getRoleById($id);
    }

    public function createRole(array $data)
    {
        return $this->roleRepository->createRole($data);
    }

    public function updateRole($id, array $data)
    {
        return $this->roleRepository->updateRole($id, $data);
    }

    public function deleteRole($id)
    {
        return $this->roleRepository->deleteRole($id);
    }

    public function addUserToRole($roleId, $userId)
    {
        // Cari role berdasarkan ID
        $role = $this->getRoleById($roleId);

        // Cari user berdasarkan ID
        $user = User::findOrFail($userId);

        // Periksa apakah user sudah memiliki role yang sama
        if ($user->role_id == $role->id) {
            throw new \Exception('User already has this role.');
        }

        // Tetapkan role ke user
        $user->role_id = $role->id;
        $user->save();

        return $role;
    }

    public function updateUserRole($roleId, $userId)
    {
        $user = User::findOrFail($userId);
        $user->role_id = $roleId;
        $user->save();

        return $user;
    }
}
