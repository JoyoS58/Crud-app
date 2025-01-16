<?php

namespace App\Repositories;

use App\Models\Activity;

class ActivityRepository implements ActivityRepositoryInterface
{
    // Mendapatkan semua aktivitas
    public function getAllActivities()
    {
        return Activity::all();
    }

    // Mendapatkan aktivitas berdasarkan ID
    public function getActivityById($id)
    {
        return Activity::findOrFail($id);
    }

    // Menambahkan aktivitas baru
    public function createActivity(array $data)
    {
        return Activity::create($data);
    }

    // Mengupdate aktivitas
    public function updateActivity($activity, array $data)
    {
        $activity->update($data);
        return $activity;
    }

    // Menghapus aktivitas
    public function deleteActivity($activity)
    {
        return $activity->delete();
    }
}
