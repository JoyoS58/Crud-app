<?php

namespace App\Http\Controllers;

use App\Services\MemberServiceInterface;
use App\Services\UserServiceInterface;
use App\Services\GroupServiceInterface;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;

class MemberController extends Controller
{
    protected $memberService;
    protected $userService;
    protected $groupService;

    public function __construct(MemberServiceInterface $memberService, UserServiceInterface $userService, GroupServiceInterface $groupService)
    {
        $this->memberService = $memberService;
        $this->userService = $userService;
        $this->groupService = $groupService;
    }

    public function index()
    {
        $members = $this->memberService->getAllMembers();
        return view('members.index', compact('members'));
    }

    public function create()
    {
        $users = $this->userService->getAllUsers();
        $groups = $this->groupService->getAllGroups();
        return view('members.create', compact('users', 'groups'));
    }

    public function store(StoreMemberRequest $request)
    {
        // Validasi sudah ditangani oleh StoreMemberRequest

        try {
            $data = $request->validated();
            $this->memberService->createMember($data);

            return redirect()->route('members.index')->with('success', 'Member added successfully');
        } catch (\Exception $e) {
            return redirect()->route('members.index')->with('error', 'Failed to add member');
        }
    }
    // Menampilkan detail group
    public function show($id)
    {
        $member = $this->memberService->getMemberById($id);
        return view('members.show', compact('member'));
    }
    public function edit($id)
    {
        $member = $this->memberService->getMemberById($id);
        $users = $this->userService->getAllUsers();
        $groups = $this->groupService->getAllGroups();
        return view('members.edit', compact('member', 'users', 'groups'));
    }

    public function update(UpdateMemberRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $data = $validated->only(['userId', 'groupId', 'join_date', 'status', 'role_in_group']);
            $this->memberService->updateMember($id, $data);

            return redirect()->route('members.index')->with('success', 'Member updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('members.index')->with('error', 'Failed to update member');
        }
    }

    public function destroy($id)
    {
        $this->memberService->deleteMember($id);
        return redirect()->route('members.index')->with('success', 'Member deleted successfully');
    }
}
