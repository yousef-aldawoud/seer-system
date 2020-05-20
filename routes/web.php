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
Route::get('/verify/{token}',"UserController@verify");

Route::get('/search', function () {
    return view('search-result');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/posts', function () {
    return view('posts');
});

Route::get('/admin', function () {
    return view('admin.dashboard');
});