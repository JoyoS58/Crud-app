<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\RoleRepository;
use App\Repositories\RoleRepositoryInterface;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;

class RoleService implements RoleServiceInterface
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getAllRoles($search = null)
    {
        try {
            return $this->roleRepository->getAllRoles($search);
        } catch (\Exception $e) {
            throw new \Exception("Failed to fetch roles: " . $e->getMessage());
        }
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
        try {
            $role = $this->roleRepository->updateRole($id, $data);

            if (!$role) {
                throw new \Exception('Role not found.');
            }
            return $this->roleRepository->updateRole($id, $data);
        } catch (\Exception $e) {
            throw new \Exception('Failed to update role: ' . $e->getMessage());
        }
    }

    public function deleteRole($id)
    {
        try {
            $role = $this->roleRepository->getRoleById($id);

            if (!$role) {
                return [
                    'success' => false,
                    'message' => 'User not found.'
                ];
            }

            $this->roleRepository->deleteRole($id);

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
    public function countRoles()
    {
        return $this->roleRepository->countRoles();
    }
}
