<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NavbarCategoryController extends Controller
{
    public function index()
    {
        return response([
            'categories' => Category::inRandomOrder()->take(5)->get()
        ], 200);
    }
}
