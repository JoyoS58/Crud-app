<?php

namespace App\Services;

interface ActivityServiceInterface
{
    public function getAllActivities();
    public function getActivityById($id);
    public function createActivity(array $data);
    public function updateActivity($id, array $data);
    public function deleteActivity($id);
}
