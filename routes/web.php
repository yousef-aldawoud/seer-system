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
Route::post('/references',"ReferenceController@create")->name('reference-create');

Route::get('password-reset/{token}','UserController@showPasswordReset');
Route::post('password-reset/{token}','UserController@resetPassword');

Route::get('/api/posts',"PostController@getPosts");

Route::post("/posts/{post}/validate","PostController@validatePost")->name('post-validate');
Route::get("/posts/{post}/validate","PostController@validatePost")->name('post-validate');

Route::get('/users',"AdminController@getUsers");
Route::post('/users/{user}/make-moderator',"AdminController@makeModerator");
Route::post('/users/{user}/remove-moderator',"AdminController@removeModerator");
Route::get('/references',"ReferenceController@get");
Route::get('/posts/{post}/references',"PostController@getReferences");
Route::post('/posts/{post}/refrences/attach',"PostController@attachReference");
Route::post('/posts/{post}/refrences/dettach',"PostController@dettachReference");
Route::get('/posts/{post}/edit',"PostController@edit")->name("post-edit");
Route::post('/posts/{post}/review',"PostReviewController@create")->name("post-review-create");
Route::post('/post-reviews/{review}/update',"PostReviewController@update")->name("post-review-update");
Route::delete('/post/{review}/delete',"PostReviewController@delete")->name("post-review-delete");
Route::get('/posts/{post}/',"PostController@show")->name("post-page");
Route::post('/posts/{post}/update',"PostController@update")->name("post-update");
Route::post('/posts/{post}/validation',"PostController@submitForValidation")->name("post-validation");
Route::get('/posts', "PostController@showUserPosts");
Route::get('/api/user/posts', "PostController@userPosts");
Route::delete('/posts/{post}/',"PostController@delete")->name("post-delete");

Route::get('/verify/{token}',"UserController@verify");

Route::get('/search', 'PostController@search');

Route::get('/login','UserController@loginView')->name("login");

// Route::get('/test', function () {
//     return view('test');
// })->name("test");

Route::get('/admin', 'AdminController@dashboard');
Route::post('/logout','UserController@logout');