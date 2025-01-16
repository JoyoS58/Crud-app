<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    public function getAllRoles()
    {
        return Role::all();
    }

    public function getRoleById($id)
    {
        return Role::findOrFail($id);
    }

    public function createRole(array $data)
    {
        return Role::create($data);
    }

    public function updateRole($id, array $data)
    {
        $role = $this->getRoleById($id);
        $role->update($data);
        return $role;
    }

    public function deleteRole($id)
    {
        $role = $this->getRoleById($id);
        return $role->delete();
    }

    public function addUserToRole($roleId, $userId)
    {
        $role = $this->getRoleById($roleId);
        $role->users()->attach($userId);
        return $role;
    }

    public function removeUserFromRole($roleId, $userId)
    {
        $role = $this->getRoleById($roleId);
        $role->users()->detach($userId);
        return $role;
    }
}
