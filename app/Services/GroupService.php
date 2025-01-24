<?php

namespace App\Services;

use App\Models\GroupUser;
use App\Models\User;
use App\Repositories\GroupRepositoryInterface;
use App\Services\GroupServiceInterface;
use App\Services\UserServiceInterface;
use Illuminate\Support\Facades\DB;

class GroupService implements GroupServiceInterface
{
    protected $groupRepository;
    protected $userService;

    public function __construct(GroupRepositoryInterface $groupRepository, UserServiceInterface $userService)
    {
        $this->groupRepository = $groupRepository;
        $this->userService = $userService;
    }

    public function getAllGroups()
    {
        return $this->groupRepository->getAllGroups();
    }

    public function getGroupById($id)
    {
        return $this->groupRepository->getGroupById($id);
    }

    public function createGroup(array $data)
    {
        return $this->groupRepository->createGroup($data);
    }

    public function updateGroup($id, array $data)
    {
        return $this->groupRepository->updateGroup($id, $data);
    }

    public function deleteGroup($id)
    {
        return $this->groupRepository->deleteGroup($id);
    }

    public function createGroupWithUsers(array $groupData, array $userId)
    {
        try {
            DB::transaction(function () use ($groupData, $userId) {
                $group = $this->groupRepository->createGroup($groupData);
                $group->members()->attach($userId);
            });
        } catch (\Exception $e) {
            throw new \Exception('Failed to create group with users: ' . $e->getMessage());
        }
    }

    public function updateGroupWithUsers($groupId, array $groupData, array $userIds)
    {
        try {
            DB::transaction(function () use ($groupId, $groupData, $userIds) {
                // Update group details
                $group = $this->groupRepository->updateGroup($groupId, $groupData);

                // Sync users in the group
                $group->members()->sync($userIds);
            });
        } catch (\Exception $e) {
            throw new \Exception('Failed to update group with users: ' . $e->getMessage());
        }
    }
    public function getAllGroupUsers()
    {
        return $this->groupRepository->getAllGroupUsers();
    }
    public function groupNameExists($groupName)
    {
        return $this->groupRepository->groupExists($groupName);
    }
    public function getGroupsByUserId($userId)
    {
        return GroupUser::find($userId)?->groups ?? collect();
    }
}
