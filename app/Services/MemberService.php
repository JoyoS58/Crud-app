<?php
namespace App\Services;

use App\Repositories\MemberRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class MemberService implements MemberServiceInterface
{
    protected $memberRepository;

    public function __construct(MemberRepositoryInterface $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public function getAllMembers()
    {
        return $this->memberRepository->getAllMembers();
    }

    public function getMemberById($id)
    {
        return $this->memberRepository->getMemberById($id);
    }

    public function createMember(array $data)
    {
        $validator = Validator::make($data, [
            'user_id' => 'required|exists:users,user_id',
            'group_id' => 'required|exists:groups,group_id',
            'join_date' => 'nullable|date',
            'status' => 'in:active,inactive',
            'role_in_group' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new \Exception('Validation failed');
        }

        // Menambahkan logika bisnis tambahan di sini jika perlu

        return $this->memberRepository->createMember($data);
    }

    public function updateMember($id, array $data)
    {
        $validator = Validator::make($data, [
            'user_id' => 'required|exists:users,user_id',
            'group_id' => 'required|exists:groups,group_id',
            'join_date' => 'nullable|date',
            'status' => 'in:active,inactive',
            'role_in_group' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new \Exception('Validation failed');
        }

        return $this->memberRepository->updateMember($id, $data);
    }

    public function deleteMember($id)
    {
        return $this->memberRepository->deleteMember($id);
    }
}
