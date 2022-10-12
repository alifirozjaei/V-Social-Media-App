<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Services\ImageService;
use Illuminate\Support\Facades\Hash;
// use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class UpdateProfileController extends Controller
{
    public function update(ProfileRequest $request)
    {
        $data = $request->only(['name', 'email', 'password', "username", "bio", "email_on_follow", "email_on_like", "email_on_reply"]);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($request->password);
        }
        if ($request->profile && $request->profile_name) {
            $data['profile'] =  ImageService::uploadImagebase64(
                $request->profile,
                public_path("profiles/"),
                $request->profile_name
            ) . "?" . Str::random(10);
        }
        $request->user()->update($data);

        return $request->user();
    }


}
