<?php

namespace App\Services\Contracts;

interface FileUploadServiceInterface
{
    public function uploadFile($file, $path, $disk='public');
    public function deleteFile($path, $disk='public');
}
