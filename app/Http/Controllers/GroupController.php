<?php

namespace App\Http\Controllers;

use App\Services\GroupServiceInterface;
use App\Services\UserServiceInterface;
use Illuminate\Http\Request;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use Illuminate\Support\Facades\Redirect;

class GroupController extends Controller
{
    protected $groupService;
    protected $userService;

    public function __construct(GroupServiceInterface $groupService, UserServiceInterface $userService)
    {
        $this->groupService = $groupService;
        $this->userService = $userService;
    }

    // Menampilkan semua group
    public function index()
    {
        $groups = $this->groupService->getAllGroups();
        $users = $this->groupService->getAllGroupUsers();
        return view('groups.index', compact('groups', 'users'));
    }

    // Menampilkan form tambah group
    public function create()
    {
        $users = $this->userService->getAllUsers();
        return view('groups.create', compact('users'));
    }

    // Menyimpan group baru
    public function store(StoreGroupRequest $request)
    {
        try {
            $validated = $request->validated();

            // Now, create the group with users
            $this->groupService->createGroupWithUsers($validated, $request->input('user_ids'));

            return redirect()->route('groups.index')->with('success', 'Group created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create group: ' . $e->getMessage()]);
        }
    }

    // Menampilkan detail group
    public function show($id)
    {
        $group = $this->groupService->getGroupById($id);
        return view('groups.show', compact('group'));
    }

    // Menampilkan form edit group
    public function edit($id)
    {
        $group = $this->groupService->getGroupById($id);
        $users = $this->userService->getAllUsers();

        return view('groups.edit', compact('group', 'users'));
    }


    // Mengupdate group
    public function update(UpdateGroupRequest $request, $id)
    {
        try {
            $validated = $request->validated();

            // User IDs for group
            $userIds = $request->input('user_ids', []);

            // Update group and sync users
            $this->groupService->updateGroupWithUsers($id, $validated, $userIds);

            return redirect()->route('groups.index')->with('success', 'Group updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update group: ' . $e->getMessage()]);
        }
    }


    // Menghapus group
    public function destroy($id)
    {
        try {
            $this->groupService->deleteGroup($id);
            return redirect()->route('groups.index')->with('success', 'Group deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete group: ' . $e->getMessage()]);
        }
    }
}
