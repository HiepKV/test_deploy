<?php

namespace App\Helpers;

use Cloudinary\Cloudinary;

class CloudinaryHelper
{
    public static function uploadBase64($base64Image, $folder = 'surveys')
    {
        try {
            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => config('cloudinary.cloud_name'),
                    'api_key'    => config('cloudinary.api_key'),
                    'api_secret' => config('cloudinary.api_secret'),
                ]
            ]);

            $upload = $cloudinary->uploadApi()->upload($base64Image, [
                'folder'        => $folder,
                'resource_type' => 'image'
            ]);

            return $upload['secure_url'] ?? null;
        } catch (\Exception $e) {
            throw new \Exception('Image upload failed: ' . $e->getMessage());
        }
    }
}
