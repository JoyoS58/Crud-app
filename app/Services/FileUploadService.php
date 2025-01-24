<?php

namespace App\Services;

use App\Services\Contracts\FileUploadServiceInterface;
use Illuminate\Support\Facades\Storage;


class FileUploadService implements FileUploadServiceInterface
{

    public function uploadFile($file, $path, $disk = 'public')
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs($path, $filename, $disk);
        return $filename;
    }

    public function deleteFile( $path, $disk = 'public')
    {
        return Storage::disk($disk)->delete($path);
    }
}