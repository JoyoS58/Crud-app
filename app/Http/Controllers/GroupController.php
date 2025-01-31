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
        // return view('groups.index', compact('groups', 'users'));
        return response()->json(['groups' => $groups, 'users' => $users]);
    }

    // Menampilkan form tambah group
    public function create()
    {
        $count = $this->userService->countUsers();
        $users = $this->userService->getAllUsers($count);
        // return view('groups.create', compact('users'));
        return response()->json(['users' => $users]);
    }

    // Menyimpan group baru
    public function store(StoreGroupRequest $request)
    {
        try {
            // Validate the input data
            $validated = $request->validated();
    
            // Check if the group name already exists (if needed)
            if ($this->groupService->groupNameExists($validated['group_name'])) {
                // return redirect()->back()->with('group_exists', true);
                return response()->json(['group_exists' => true]);
            }
    
            // Create the group with users
            $this->groupService->createGroupWithUsers($validated, $request->input('user_ids'));
    
            // return redirect()->route('groups.index')->with('success', 'Group created successfully.');
            return response()->json(['success' => 'Group created successfully.']);
        } catch (\Exception $e) {
            // Return error if something went wrong
            // return redirect()->back()->withErrors(['error' => 'Failed to create group: ' . $e->getMessage()]);
            return response()->json(['error' => 'Failed to create group: ' . $e->getMessage()]);
        }
    }

    // Menampilkan detail group
    public function show($id)
    {
        $group = $this->groupService->getGroupById($id);
        // return view('groups.show', compact('group'));
        return response()->json(['group' => $group]);
    }

    // Menampilkan form edit group
    public function edit($id)
    {
        $group = $this->groupService->getGroupById($id);
        $count = $this->userService->countUsers();
        $users = $this->userService->getAllUsers($count);

        // return view('groups.edit', compact('group', 'users'));
        return response()->json(['group' => $group, 'users' => $users]);
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

            // return redirect()->route('groups.index')->with('success', 'Group updated successfully.');
            return response()->json(['success' => 'Group updated successfully.']);
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors(['error' => 'Failed to update group: ' . $e->getMessage()]);
            return response()->json(['error' => 'Failed to update group: ' . $e->getMessage()]);
        }
    }


    // Menghapus group
    public function destroy($id)
    {
        try {
            $this->groupService->deleteGroup($id);
            // return redirect()->route('groups.index')->with('success', 'Group deleted successfully.');
            return response()->json(['success' => 'Group deleted successfully.']);
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors(['error' => 'Failed to delete group: ' . $e->getMessage()]);
            return response()->json(['error' => 'Failed to delete group: ' . $e->getMessage()]);
        }
    }
}
