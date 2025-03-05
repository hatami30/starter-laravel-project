<?php

use App\Enums\EnumFileSystemDisk;
use Illuminate\Support\Facades\Storage;

if (!function_exists('getUserImageProfilePath')) {
    function getUserImageProfilePath($user)
    {
        $disk = env('FILESYSTEM_DISK');
        $placeholderUrl = 'https://placehold.co/150';
        $appUrl = rtrim(env('APP_URL'), '/');
        $publicHtmlPath = base_path('../public_html');

        if ($disk === EnumFileSystemDisk::PUBLIC ->value) {
            if ($user->image_profile && Storage::disk('public')->exists($user->image_profile)) {
                return asset('storage/' . $user->image_profile);
            }
        } elseif ($disk === EnumFileSystemDisk::PUBLIC_UPLOADS->value) {
            $filePath = $user->image_profile;
            $fullPath = $publicHtmlPath . '/' . $filePath;
            if ($user->image_profile && file_exists($fullPath)) {
                return $appUrl . '/' . $filePath;
            }
        }

        return $placeholderUrl;
    }
}