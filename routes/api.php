<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// send email verification email
Route::get("/email/resend", 'Auth\VerificationController@resend')->name("verification.resend");

// send reset password email
Route::post("/password/email", "Auth\ForgotPasswordController@sendResetLinkEmail")->name("password.email");

//  reset password
Route::post("/password/reset", "Auth\ResetPasswordController@reset")->name("password.update");


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // get login user
    Route::get('/me', function (Request $request) {
        return $request->user()->makeVisible(['email']);
    });

    // user profile update
    Route::patch("/profile", "UpdateProfileController@update")
        ->name('profile.update');

    // upload dropzone image base64
    Route::post('/upload-post-image', "Post\UploadPostImageController")
        ->name("upload_post_image");

    // create darft when create first draft
    Route::post('/posts/create', "Draft\DraftController@store")
        ->name("draft.store");

    // update and edit draft when writing
    Route::patch('/drafts/{draft}', "Draft\DraftController@update")
        ->name("draft.update");

    // get draft
    Route::get('/drafts/{draft}', "Draft\DraftController@show")
        ->name("draft.show");

    // save post
    Route::post('/posts', 'Post\PostController@store')->name('post.store');

    // get user all posts
    Route::get('/posts/all-posts', "Post\AllUserPostsController");

    // get all user drafts
    Route::get('/posts/all-drafts', "Post\AllUserDraftsController");

    // get post for edit
    Route::get("/posts/{post:slug}/edit", "Post\PostController@show")->name('post.show');

    // edit post
    Route::patch("/posts/{post:slug}/edit", "Post\PostController@edit")->name('post.edit');

    // final edit post
    Route::patch("/posts/{post:slug}", "Post\PostController@update")->name('post.update');

    // delete draft
    Route::delete('drafts/{draft:link}', 'Draft\DraftController@destroy')->name('draft.destroy');

    // delete post
    Route::delete('posts/{post:slug}', 'Post\PostController@destroy')->name('post.destroy');

    // save new comment
    Route::post('comments/{post:slug}', "Comment\CommentController@store")->name('comment.store');

    // delete comment
    Route::delete('comments/{comment:id}', "Comment\CommentController@destroy")->name('comment.destroy');

    // edit comment
    Route::patch('comments/{comment:id}', "Comment\CommentController@update")->name('comment.update');

    // save reply comment
    Route::post('replies/{post:slug}', "Comment\ReplyCommentController@store")->name('reply.store');

    // bookmark post
    Route::post("/bookmarks/{post:slug}", 'Post\BookmarkController@store')->name('bookmark.store');

    // unbookmark post
    Route::delete("/bookmarks/{post:slug}", 'Post\BookmarkController@destroy')->name('bookmark.destroy');

    // like post
    Route::post("/likes/{post:slug}", 'Post\LikeController@store')->name('like.store');

    // unlike post
    Route::delete("/likes/{post:slug}", 'Post\LikeController@destroy')->name('like.destroy');

    // follow and unfollow user
    Route::post('follows/{user:username}', "User\FollowController")->name('user.follow');

    // get notification
    Route::get('notifications', "User\NotificationController@index")->name('notification.index');

    // mark as read for notification
    Route::patch('notifications/{notifications} ', "User\NotificationController@update")->name('notification.update');

    // get user bookmarked post
    Route::get('bookmarked-posts', "User\BookmarkedPostController@index")->name('bookmarked.posts');

    // get user liked post
    Route::get('liked-posts', "User\LikedPostController@index")->name('liked.posts');

    // get following user  new posts
    Route::get('following-posts', 'Post\FollowingPostController@index')->name('following.posts');


    Route::get('following-posts-all', 'Post\FollowingPostController@newFollowingPosts')->name('following.posts.all');

    // get following user all posts
});

// show post
Route::get('/posts/{post:slug}', "Post\ShowPostController")->name('show.post');

// select category posts
Route::get('posts/category/{category:slug}', "Post\PostCategoryController")->name('posts-category.show');

// select random categories for show in navbar
Route::get('/navbar-categories', 'Category\NavbarCategoryController@index')->name('navbar.category');

// show user profile
Route::get('user-posts/{user:username}', "User\UserPostController@index")->name('user.posts');

// get user following
Route::get("user/{user:username}/following", 'User\UserPostController@followingList')
    ->name('followings.list');

// get user followers
Route::get("user/{user:username}/follower", 'User\UserPostController@followerList')
    ->name('followers.list');

// get new post for home page
Route::get('home-posts', "HomePostController@index")->name('home.index');

// get random post from home page
Route::get('random-posts', "HomePostController@randomPost")->name('home.random');

// get trending posts
Route::get('trending', 'Post\TrendingPostController@index')->name('trending.post');

// search posts
Route::get('search/posts/{post}', 'Search\SearchPostController@index')->name('search.post');

// search users
Route::get('search/users/{user}', 'Search\SearchUserController@index')->name('search.user');

// search categories
Route::get('search/categories/{category}', 'Search\SearchCategoryController@index')->name('search.category');
