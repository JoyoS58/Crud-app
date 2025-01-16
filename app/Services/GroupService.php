<?php

namespace App\Services;

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
}
