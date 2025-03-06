<?php

namespace App\Services;

use App\Enums\EnumFileSystemDisk;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageManagementService
{
    protected function publicUploadsPath($folder = '')
    {
        return '../public_html/' . $folder;
    }

    public function uploadImage(UploadedFile $file, array $options = [])
    {
        $currentImagePath = $options['currentImagePath'] ?? null;
        $disk = $options['disk'] ?? EnumFileSystemDisk::PUBLIC ->value;
        $folder = $options['folder'] ?? null;

        if ($disk === EnumFileSystemDisk::PUBLIC ->value) {
            // Handle file deletion if current image exists
            if ($currentImagePath && Storage::disk('public')->exists($currentImagePath)) {
                Storage::disk('public')->delete($currentImagePath);
            }

            // Store new file and return its path
            return $file->store($folder, 'public');
        } elseif ($disk === EnumFileSystemDisk::PUBLIC_UPLOADS->value) {
            $directory = $this->publicUploadsPath($folder);

            // Create directory if it doesn't exist
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            // Generate unique file name to avoid conflicts
            $fileName = time() . '.' . $file->extension();

            // Delete the current image if it exists
            if ($currentImagePath && File::exists($this->publicUploadsPath($currentImagePath))) {
                File::delete($this->publicUploadsPath($currentImagePath));
            }

            // Move the file to the specified directory
            $file->move($directory, $fileName);
            return $folder . '/' . $fileName;
        }

        return null;
    }

    public function destroyImage($currentImagePath, $disk = EnumFileSystemDisk::PUBLIC ->value)
    {
        if ($disk === EnumFileSystemDisk::PUBLIC ->value) {
            if ($currentImagePath && Storage::disk('public')->exists($currentImagePath)) {
                return Storage::disk('public')->delete($currentImagePath);
            }
        } elseif ($disk === EnumFileSystemDisk::PUBLIC_UPLOADS->value) {
            if ($currentImagePath && File::exists($this->publicUploadsPath($currentImagePath))) {
                return File::delete($this->publicUploadsPath($currentImagePath));
            }
        }

        return false;
    }
}
