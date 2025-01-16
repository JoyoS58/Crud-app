<?php

namespace App\Services;

interface MemberServiceInterface
{
    public function getAllMembers();
    public function getMemberById($id);
    public function createMember(array $data);
    public function updateMember($id, array $data);
    public function deleteMember($id);
}
