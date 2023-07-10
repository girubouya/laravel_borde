<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('posts',PostController::class);
Route::get('comment',[CommentController::class,'index'])->name('comment.index');
Route::post('comment',[CommentController::class,'store'])->name('comment.store');
Route::get('comment/edit/{id}',[CommentController::class,'edit'])->name('comment.edit');
Route::post('comment/edit/{id}',[CommentController::class,'update'])->name('comment.update');
Route::post('comment/{id}',[CommentController::class,'delete'])->name('comment.destroy');

require __DIR__.'/auth.php';
