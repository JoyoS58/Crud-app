<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Services\ActivityService;
use App\Services\Contracts\FileUploadServiceInterface;
use Illuminate\Http\Request;

class ActivityController extends Controller
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
        $activities = $this->activityService->getAllActivities();
        return view('activities.index', compact('activities'));
    }

    public function create()
    {
        $data = $this->activityService->getFormDependencies();
        return view('activities.create', $data);
    }

    public function store(StoreActivityRequest $request)
    {
        $validated = $request->validated();
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if (!empty($activity) && !empty($activity->file)) {
                $this->fileUploadService->deleteFile('activity/file/' . $activity->file);
            }
    
            // Upload file baru
            $validated['file'] = $this->fileUploadService->uploadFile($request->file('file'), 'activity/file/');
        }
        $this->activityService->createActivity($validated);

        return redirect()->route('activities.index')->with('success', 'Activity created successfully.');
    }

    public function show($id)
    {
        $activity = $this->activityService->getActivityById($id);
        return view('activities.show', compact('activity'));
    }

    public function edit($id)
    {
        $data = $this->activityService->getEditDependencies($id);
        return view('activities.edit', $data);
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

        return redirect()->route('activities.index')->with('success', 'Activity updated successfully.');
    }

    public function destroy($id)
    {
        $activity = $this->activityService->getActivityById($id);

        if (!empty($activity->file)) {
            $this->fileUploadService->deleteFile('activity/file/' . $activity->file);
        }
        $this->activityService->deleteActivity($id);

        return redirect()->route('activities.index')->with('success', 'Activity deleted successfully.');
    }
}
