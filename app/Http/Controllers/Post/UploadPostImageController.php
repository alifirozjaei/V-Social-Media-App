<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Post;
use App\Services\ImageService;
use Illuminate\Http\Request;

class UploadPostImageController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            "file" => ['required', 'image']
        ]);

        $imageName = ImageService::uploadImageFile($request->file("file"),  Post::getPublickDirectory());

        return response([
            'data' => Post::getImageDirectory() . $imageName
        ]);
    }
}
