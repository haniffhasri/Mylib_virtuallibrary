<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Auth\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Auth::routes();

// borrow
Route::get('/borrow', [BorrowController::class,'index'])->name('borrow.index');

Route::get('/borrow/show', [BorrowController::class,'show'])->name('borrow.show');

Route::get('/borrow/{id}', [BorrowController::class, 'borrow_book'])->name('borrow_book');

Route::delete('/borrow/delete/{id}', [BorrowController::class, 'delete'])->name('borrow.delete');

Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');

Route::get('/profile', [DashboardController::class,'show'])->name('profile');

// book
Route::get('/book', [BookController::class,'index'])->name('book.index');

Route::get('/book/insert', [BookController::class, 'create'])->name('book.create');

Route::get('/book/{id}', [BookController::class, 'show'])->name('book.show');

Route::get('/book/destroy/{id}', [BookController::class, 'destroy'])->name('book.destroy');

Route::get('/book/edit/{id}', [BookController::class, 'edit'])->name('book.edit');

Route::post('/book/update/{id}', [BookController::class, 'update'])->name('book.update');

Route::post('/book', [BookController::class, 'store'])->name('book.store');

Route::delete('/book/{id}/delete-media', [BookController::class, 'deleteMedia'])->name('book.deleteMedia');

Route::delete('/book/{id}/delete-image', [BookController::class, 'deleteImage'])->name('book.deleteImage');

// comment
Route::post('/books/{book}/comments', [CommentController::class, 'store'])->name('comments.store');

// admin
Route::get('/admin/user', [UserController::class,'index'])->name('admin.user');

Route::delete('/admin/delete/{id}', [UserController::class, 'delete'])->name('user.delete');

Route::put('/admin/update-role/{id}', [UserController::class, 'updateRole'])->name('user.updateRole');

// profile
Route::get('/user/edit/{id}', [ProfileController::class, 'edit'])->name('user.edit');

Route::post('/user/update/{id}', [ProfileController::class, 'update'])->name('user.update');

Route::get('/profile-picture', [ProfileController::class, 'show'])->name('profile.picture.show');

Route::post('/profile-picture', [ProfileController::class, 'store'])->name('profile.picture.store');

Auth::routes();