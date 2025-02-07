<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    public function getAllRoles($search = null)
    {
        $query = Role::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('role_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('role_description', 'LIKE', '%' . $search . '%');
            });
        }

        return $query->withCount(['users as user_count'])->get();
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
        return $role->update($data);
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
    public function countRoles()
    {
        return Role::count();
    }
}
