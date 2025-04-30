<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('welcome');
});

// Logout
Route::get('logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Auth routes
Auth::routes();

// Public Book Routes
Route::prefix('book')->name('book.')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('index');
    Route::get('/{id}', [BookController::class, 'show'])
        ->where('id', '[0-9]+')
        ->name('show');
});

// Comments (public for book pages)
Route::post('/books/{book}/comments', [CommentController::class, 'store'])->name('comments.store');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'show'])->name('profile');

    // Book Routes (insert, update, delete, media actions)
    Route::prefix('book')->name('book.')->group(function () {
        Route::get('/insert', [BookController::class, 'create'])->name('create');
        Route::post('/', [BookController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [BookController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [BookController::class, 'update'])->name('update');
        Route::get('/destroy/{id}', [BookController::class, 'destroy'])->name('destroy');
        Route::delete('/{id}/delete-media', [BookController::class, 'deleteMedia'])->name('deleteMedia');
        Route::delete('/{id}/delete-image', [BookController::class, 'deleteImage'])->name('deleteImage');
        Route::get('/search', [BookController::class, 'search'])->name('search');
    });

    // Borrow
    Route::prefix('borrow')->name('borrow.')->group(function () {
        Route::get('/', [BorrowController::class, 'index'])->name('index');
        Route::get('/show', [BorrowController::class, 'show'])->name('show');
        Route::get('/{id}', [BorrowController::class, 'borrow_book'])->name('book');
        Route::delete('/delete/{id}', [BorrowController::class, 'delete'])->name('delete');
    });

    // Forum
    Route::resource('forums', ForumController::class);
    Route::resource('forums.threads', ThreadController::class);
    Route::resource('threads.comments', CommentController::class);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

    // Admin - User Management
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/user', [UserController::class, 'index'])->name('user');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
        Route::put('/update-role/{id}', [UserController::class, 'updateRole'])->name('user.updateRole');
    });

    // Profile (picture and bio)
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/edit/{id}', [ProfileController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ProfileController::class, 'update'])->name('update');
    });

    Route::get('/profile-picture', [ProfileController::class, 'show'])->name('profile.picture.show');
    Route::post('/profile-picture', [ProfileController::class, 'store'])->name('profile.picture.store');
});
