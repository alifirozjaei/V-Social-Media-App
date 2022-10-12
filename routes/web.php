<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;



// Route::get('{url?}', function ($url = null) {
//     return view('home');
// })->where('url', '.*');

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/link/{post:short_link}', 'ShortLinkPostController')->name('short.link');


Route::fallback(function () {
    return view('home');
});

// Auth::routes();
Route::post("/login", 'Auth\LoginController@login');

Route::get("/login", function () {
    return view('home');
})->name('login');

Route::post("/logout", 'Auth\LoginController@logout')->name("logout");

Route::post("/register", 'Auth\RegisterController@register')->name("register");

Route::get("/email/verify/{id}/{hash}", 'Auth\VerificationController@verify')->name("verification.verify");

Route::get("/password/reset/{token}", function () {
    return view('home');
})->name('password.reset');
