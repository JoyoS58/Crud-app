<?php

namespace App\Repositories;

interface ActivityRepositoryInterface
{
    public function getAllActivities();
    public function getActivityById($id);
    public function createActivity(array $data);
    public function updateActivity($activity, array $data);
    public function deleteActivity($activity);
}
