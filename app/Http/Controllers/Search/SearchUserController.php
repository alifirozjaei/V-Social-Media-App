<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class SearchUserController extends Controller
{
    public function index(Request $request, $user)
    {
        $users = User::where('name', 'LIKE', "%{$user}%")
            ->orWhere('username', 'LIKE', "%{$user}%")
            ->orWhere('bio', 'LIKE', "%{$user}%")
            ->simplePaginate(10);
        return response([
            'users' => $users
        ], 200);
    }
}
