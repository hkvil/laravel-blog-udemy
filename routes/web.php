<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

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

// User related routes
Route::get('/', [UserController::class, "showCorrectHomepage"])->name('login');
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);

// Blog post related routes
Route::get('/create-post', [PostController::class, 'showCreateForm'])->middleware('anuan');
Route::post('/create-post', [PostController::class, 'storeNewPost']);
Route::get('/post/{post}',[PostController::class,'viewSinglePost']);
Route::delete('/post/{post}',[PostController::class,'delete'])->middleware('can:delete,post');
Route::get('/post/{post}/edit',[PostController::class,'showEditForm'])->middleware('can:update,post');
Route::put('/post/{post}',[PostController::class,'update'])->middleware('can:update,post');

// Profile related routes
Route::get('/profile/{user:username}', [UserController::class, 'viewProfile']);


