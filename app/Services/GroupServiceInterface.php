<?php

namespace App\Services;

interface GroupServiceInterface
{
    public function getAllGroups();
    public function getGroupById($id);
    public function createGroup(array $data);
    public function updateGroup($id, array $data);
    public function deleteGroup($id);
    public function createGroupWithUsers(array $groupData, array $userIds);
    public function updateGroupWithUsers($groupId, array $groupData, array $userIds);
    public function getAllGroupUsers();
    public function groupNameExists($groupName);
    public function getGroupsByUserId($userId);
}
