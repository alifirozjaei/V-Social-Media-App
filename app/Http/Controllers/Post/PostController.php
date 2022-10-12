<?php

namespace App\Http\Controllers\Post;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\support\Str;
use App\Services\ImageService;

class PostController extends Controller
{
    public function store(PostRequest $request)
    {
        $data = $request->only([
            'title',
            'content',
            'description',
            'user_id',
            'min_read'
        ]);

        // save image
        if ($request->image && $request->imageName) {
            $data['image'] =  ImageService::uploadPostImagebase64(
                $request->image,
                public_path(Post::getImageDirectory()),
                $request->imageName
            );
        }


        $post = new Post($data);
        $post->save();

        // select old category from DB and detect new category
        $categories = [];
        $selectedCategories = Category::whereIn('title', $request->categories)->get();
        $shouldCreateCategories = collect($request->categories)->diff($selectedCategories->pluck('title'));

        // create new category
        foreach ($shouldCreateCategories->toArray() as $categoryName) {
            $categories[] = Category::create(['title' => $categoryName]);
        }

        // attach category to post
        $post->categories()->attach(
            collect($categories)->pluck('id')->concat($selectedCategories->pluck('id'))
        );

        return response(['data' => $post], 200);
    }

    public function show(Post $post)
    {
        $this->authorize('view', $post);
        return $post->append('categories_title');
    }

    public function edit(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();
        $post->update($data);


        return $post;
    }

    public function update(Post $post, PostRequest $request)
    {
        $data = $request->only([
            'title',
            'content',
            'description',
            'user_id',
            'min_read'
        ]);

        // save image
        if ($request->image && $request->imageName) {
            $data['image'] =  ImageService::uploadPostImagebase64(
                $request->image,
                public_path(Post::getImageDirectory()),
                $request->imageName
            );
        } else {
            unset($data['image']);
        }


        $post->update($data);

        // select old category from DB and detect new category
        $categories = [];
        $selectedCategories = Category::whereIn('title', $request->categories)->get();
        $shouldCreateCategories = collect($request->categories)->diff($selectedCategories->pluck('title'));

        // create new category
        foreach ($shouldCreateCategories->toArray() as $categoryName) {
            $categories[] = Category::create(['title' => $categoryName]);
        }

        // attach category to post
        $post->categories()->sync(
            collect($categories)->pluck('id')->concat($selectedCategories->pluck('id'))
        );

        return response(['data' => $post], 200);
    }

    public function destroy(Post $post)
    {
        $this->authorize('view', $post);
        $post->delete();
        return response(['data' => 'ok'], 200);
    }
}
