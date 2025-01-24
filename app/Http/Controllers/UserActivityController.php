<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use App\Models\Group;
use App\Models\User;
use App\Services\ActivityService;
use App\Services\Contracts\FileUploadServiceInterface;
use Illuminate\Http\Request;


class UserActivityController extends Controller
{
    protected $activityService;
    protected $fileUploadService;

    public function __construct(ActivityService $activityService, FileUploadServiceInterface $fileUploadService)
    {
        $this->activityService = $activityService;
        $this->fileUploadService = $fileUploadService;
    }

    public function index()
    {
        $userId = auth()->id(); // Get the logged-in user's ID
        $activities = Activity::where('user_id', $userId)->get(); // Filter activities by user ID

        return view('userActivities.index', compact('activities'));
    }

    public function create()
    {

        $users = User::all();
        $groups = Group::whereHas('users', function ($query) {
            $query->where('users.user_id', auth()->id());
        })->get();

        return view('userActivities.create', compact('groups', 'users'));
    }

    public function store(StoreActivityRequest $request)
    {
        $userId = auth()->id();
        $activity = Activity::where('user_id', $userId)->first();
        $validated = $request->validated();

        if ($request->hasFile('file')) {
            if (!empty($activity) && !empty($activity->file)) {
                $this->fileUploadService->deleteFile('activity/file/' . $activity->file);
            }

            // Upload file baru
            $validated['file'] = $this->fileUploadService->uploadFile($request->file('file'), 'activity/file/');
        }

        $this->activityService->createActivity($validated);

        return redirect()->route('userActivities.index')->with('success', 'Activity created successfully.');
    }


    public function show($id)
    {
        $activity = $this->activityService->getActivityById($id);
        return view('userActivities.show', compact('activity'));
    }

    public function edit($id)
    {
        $data = $this->activityService->getEditDependencies($id);
        return view('userActivities.edit', $data);
    }

    public function update(UpdateActivityRequest $request, $id)
    {
        $activity = $this->activityService->getActivityById($id);
        $validated = $request->validated();

        if ($request->hasFile('file')) {
            if (!empty($activity->file)) {
                $this->fileUploadService->deleteFile('activity/file/' . $activity->file);
            }
            $validated['file'] = $this->fileUploadService->uploadFile($request->file('file'), 'activity/file/');
        }

        $this->activityService->updateActivity($id, $validated);

        return redirect()->route('userActivities.index')->with('success', 'Activity updated successfully.');
    }


    public function destroy($id)
    {
        $activity = $this->activityService->getActivityById($id);

        if (!empty($activity->file)) {
            $this->fileUploadService->deleteFile('activity/file/' . $activity->file);
        }

        $this->activityService->deleteActivity($id);

        return redirect()->route('userActivities.index')->with('success', 'Activity deleted successfully.');
    }
}
