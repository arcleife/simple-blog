<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;

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
    return Inertia::render('Login');
});

Route::get('/', [BlogController::class, 'index'])->name('dashboard')
    ->middleware(['auth', 'verified']);

// BLOG
Route::get('/blog/view/{blog}', [BlogController::class, 'show'])->name('blog')
    ->middleware(['auth', 'verified']);

Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create')
    ->middleware(['auth', 'verified']);

Route::post('/blog/create', [BlogController::class, 'store'])->name('blog.store')
    ->middleware(['auth', 'verified']);

Route::get('/blog/edit/{blog}', [BlogController::class, 'edit'])->name('blog.edit')
    ->middleware(['auth', 'verified']);

Route::put('/blog/edit/{blog}', [BlogController::class, 'update'])->name('blog.update')
    ->middleware(['auth', 'verified']);

Route::delete('/blog/{blog}', [BlogController::class, 'delete'])->name('blog.delete')
    ->middleware(['auth', 'verified']);

// USER

Route::get('/users', [UserController::class, 'list'])->name('user.list')
    ->middleware(['auth', 'verified', 'admin']);

Route::get('/user/create', [UserController::class, 'create'])->name('user.create')
    ->middleware(['auth', 'verified', 'admin']);

Route::post('/user/create', [UserController::class, 'store'])->name('user.store')
    ->middleware(['auth', 'verified', 'admin']);

Route::get('/user/{user}', [UserController::class, 'edit'])->name('user.edit')
    ->middleware(['auth', 'verified', 'admin']);

Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update')
    ->middleware(['auth', 'verified', 'admin']);

Route::delete('/user/{user}', [UserController::class, 'delete'])->name('user.delete')
    ->middleware(['auth', 'verified', 'admin']);

// COMMENT

Route::post('/comment', [CommentController::class, 'store'])->name('comment.store')
    ->middleware(['auth', 'verified']);

Route::delete('/comment/{comment}', [CommentController::class, 'delete'])->name('comment.delete')
    ->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
