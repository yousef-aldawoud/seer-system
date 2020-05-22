<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/register',"UserController@register");
Route::post('/login',"UserController@login");
Route::post('/posts/create',"PostController@create");
Route::get('/posts/{post}/edit',"PostController@edit")->name("post-edit");
Route::post('/posts/{post}/update',"PostController@update")->name("post-update");
Route::get('/posts', "PostController@showUserPosts");
// Route::get('/api/user/posts', "PostController@userPosts");
Route::delete('/posts/{post}/',"PostController@delete")->name("post-delete");

Route::get('/verify/{token}',"UserController@verify");

Route::get('/search', function () {
    return view('search-result');
});

Route::get('/login', function () {
    return view('login');
})->name("login");


Route::get('/admin', function () {
    return view('admin.dashboard');
});