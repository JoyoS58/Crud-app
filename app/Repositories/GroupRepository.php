<?php

namespace App\Repositories;

use App\Models\Group;

class GroupRepository implements GroupRepositoryInterface
{
    public function getAllGroups()
    {
        return Group::all();
    }

    public function getGroupById($id)
    {
        return Group::with('users')->findOrFail($id);
    }
    
    public function createGroup(array $data)
    {
        return Group::create($data);
    }

    public function updateGroup($id, array $data)
    {
        $group = $this->getGroupById($id);
        $group->update($data);
        return $group;
    }

    public function deleteGroup($id)
    {
        $group = $this->getGroupById($id);
        $group->delete();
    }
}
