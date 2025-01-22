<?php

namespace App\Repositories;

use App\Models\Member;

class MemberRepository implements MemberRepositoryInterface
{
    public function getAllMembers($perPage = 10)
    {
        return Member::paginate($perPage);
    }

    public function getMemberById($id)
    {
        return Member::findOrFail($id);
    }

    public function createMember(array $data)
    {
        return Member::create($data);
    }

    public function updateMember($id, array $data)
    {
        $member = $this->getMemberById($id);
        $member->update($data);
        return $member;
    }

    public function deleteMember($id)
    {
        $member = $this->getMemberById($id);
        $member->delete();
    }
}
