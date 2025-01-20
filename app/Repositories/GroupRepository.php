<?php

namespace App\Repositories;

use App\Models\Group;
use App\Models\GroupUser;

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
    public function updateGroupWithUsers($groupId, array $groupData, array $userIds)
    {
        $group = $this->getGroupById($groupId); // Ensure the group exists

        if (!$group) {
            throw new \Exception('Group not found');
        }

        // Update group data
        $group->update($groupData);

        // Sync users
        $group->members()->sync($userIds);

        return $group;
    }
    public function getAllGroupUsers()
    {
        return GroupUser::all();
    }
}
