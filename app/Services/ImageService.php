<?php

namespace App\Services;

use Illuminate\support\Str;
use Intervention\Image\Facades\Image;

class ImageService
{
    static public function uploadImageFile($imageFile, $fileDir, $fileName = null)
    {
        $imageName = $fileName ?? static::getFileName($imageFile);
        $imageDir = $fileDir;
        $imageFile->move($imageDir, $imageName);
        return $imageName;
    }

    static public function getFileName($imageFile)
    {
        return  Str::random(15) . "." . $imageFile->getClientOriginalExtension();
    }

    static public function uploadImagebase64($image, $imageDir,  $imageName)
    {
        $filname = static::getFileNameBase64($imageName);
        $path = $imageDir . $filname;
        Image::make($image)
            // ->fit(100)
            ->resize(100, 100)
            ->save($path);
        return $filname;
    }

    static public function getFileNameBase64($imageName)
    {
        return (optional(request()->user())->username ?? Str::random(15)) . "." . Str::afterLast($imageName, '.');
    }

    static public function uploadPostImagebase64($image, $imageDir,  $imageName)
    {
        $filname = Str::random(15) . "." . Str::afterLast($imageName, '.');
        $path = $imageDir . $filname;
        Image::make($image)
            ->save($path);
        return $filname;
    }
}
