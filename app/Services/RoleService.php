<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\RoleRepositoryInterface;

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
        // Get the role by ID
        $role = $this->roleRepository->getRoleById($roleId);
        
        $user = User::findOrFail($userId);
        // Check if the user is already assigned to the role
        if ($user->roles->contains($role)) {
            return redirect()->route('roles.show', $roleId)
                ->withErrors(['error' => 'User already has this role.']);
        }

        return $role;
    }



    public function removeUserFromRole($roleId, $userId)
    {
        return $this->roleRepository->removeUserFromRole($roleId, $userId);
    }
}
