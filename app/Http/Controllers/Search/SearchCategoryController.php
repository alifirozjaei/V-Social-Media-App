<?php

namespace App\Http\Controllers\Search;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchCategoryController extends Controller
{
    public function index(Request $request, $category)
    {
        $categories = Category::where('title', 'LIKE', "%{$category}%")
            ->simplePaginate(10);
        return response([
            'categories' => $categories
        ], 200);
    }
}
