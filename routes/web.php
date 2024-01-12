<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;

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

Route::get('/admin-only',function(){
        return "You are an admin";
})->middleware('can:visitAdminPage');

// Catatan:anuan itu hanya cek apakah user sudah login atau belum auth()->check()


// User related routes
Route::get('/', [UserController::class, "showCorrectHomepage"])->name('login');
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);
Route::get('/manage-avatar',[UserController::class,'showAvatarForm'])->middleware('anuan');
Route::post('/manage-avatar',[UserController::class,'storeAvatar'])->middleware('anuan');


// Blog post related routes
Route::get('/create-post', [PostController::class, 'showCreateForm'])->middleware('anuan');
Route::post('/create-post', [PostController::class, 'storeNewPost']);
Route::get('/post/{post}',[PostController::class,'viewSinglePost']);
Route::delete('/post/{post}',[PostController::class,'delete'])->middleware('can:delete,post');
Route::get('/post/{post}/edit',[PostController::class,'showEditForm'])->middleware('can:update,post');
Route::put('/post/{post}',[PostController::class,'update'])->middleware('can:update,post');

// Follow related routes
Route::post('/create-follow/{user:username}',[FollowController::class,'createFollow'])->middleware('anuan');
Route::post('/remove-follow/{user:username}',[FollowController::class,'removeFollow'])->middleware('anuan');

// Profile related routes
Route::get('/profile/{user:username}', [UserController::class, 'viewProfile']);


