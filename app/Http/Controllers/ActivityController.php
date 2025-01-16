<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Services\ActivityService;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    protected $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
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
        $validated = $request->validated();
        $this->activityService->updateActivity($id, $validated);

        return redirect()->route('activities.index')->with('success', 'Activity updated successfully.');
    }

    public function destroy($id)
    {
        $this->activityService->deleteActivity($id);

        return redirect()->route('activities.index')->with('success', 'Activity deleted successfully.');
    }
}
