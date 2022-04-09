<?php

use Illuminate\Support\Facades\Route;

Route::post('register', 'App\Http\Controllers\UserController@register');
Route::post('login', 'App\Http\Controllers\UserController@authenticate');

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::post('user', 'App\Http\Controllers\UserController@getAuthenticatedUser');
    Route::resource('posts', 'App\Http\Controllers\PostsController', ['only' => ['index', 'store']]);
    Route::resource('videos', 'App\Http\Controllers\VideosController', ['only' => ['index', 'store']]);
});
