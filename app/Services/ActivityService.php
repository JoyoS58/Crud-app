<?php

namespace App\Services;

use App\Repositories\ActivityRepositoryInterface;
use App\Models\User;
use App\Models\Group;

class ActivityService
{
    protected $activityRepository;

    public function __construct(ActivityRepositoryInterface $activityRepository)
    {
        $this->activityRepository = $activityRepository;
    }

    // Mendapatkan semua aktivitas
    public function getAllActivities()
    {
        return $this->activityRepository->getAllActivities();
    }

    public function getActivityById($id)
    {
        return $this->activityRepository->getActivityById($id);
    }

    // Menambahkan aktivitas baru
    public function createActivity(array $data)
    {
        return $this->activityRepository->createActivity($data);
    }

    // Mengupdate aktivitas
    public function updateActivity($id, array $data)
    {
        $activity = $this->activityRepository->getActivityById($id);
        return $this->activityRepository->updateActivity($activity, $data);
    }

    // Menghapus aktivitas
    public function deleteActivity($id)
    {
        $activity = $this->activityRepository->getActivityById($id);
        return $this->activityRepository->deleteActivity($activity);
    }

    public function getFormDependencies()
    {
        return [
            'users' => User::all(),
            'groups' => Group::all(),
        ];
    }

    public function getEditDependencies($id)
    {
        return [
            'activity' => $this->activityRepository->getActivityById($id),
            'users' => User::all(),
            'groups' => Group::all(),
        ];
    }
}
