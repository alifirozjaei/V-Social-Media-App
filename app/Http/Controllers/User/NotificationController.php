<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        return response([
            'data' => $request->user()->notifications
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $request->user()
            ->notifications()
            ->where('id', $id)
            ->first()
            ->markAsRead();

        return response(
            ['data' => 'ok'],
            200
        );
    }
}
