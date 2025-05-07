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

// Forum Route
Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
Route::middleware(['auth'])->group(function () {
    Route::get('/forum/create', [ForumController::class, 'create'])->name('forum.create');
    Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');
});
Route::get('/forum/{slug}', [ForumController::class, 'show'])->name('forum.show');

// Comments
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/comments/{id}', [CommentController::class, 'delete'])->name('comments.delete');

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

    // thread
    Route::post('/forum/{forum}/threads', [ThreadController::class, 'store'])->name('forum.threads.store');
    Route::get('/edit/{id}', [ThreadController::class, 'edit'])->name('forum.threads.edit');
    Route::post('/update/{id}', [ThreadController::class, 'update'])->name('forum.threads.update');
    Route::get('/delete/{id}', [ThreadController::class, 'delete'])->name('forum.threads.delete');
    Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    // Route::post('/notifications/{id}/read', function ($id) {
    //     Auth::user()->notifications()->find($id)?->markAsRead();
    //     return back();
    // })->name('notifications.markAsRead');
    

    // Admin - User Management
    Route::get('admin/user', [UserController::class, 'index'])->name('admin.user');
    Route::put('admin/update-role/{id}', [UserController::class, 'updateRole'])->name('user.updateRole');
    Route::delete('admin/delete/{id}', [UserController::class, 'delete'])->name('user.delete');

    // Profile (picture and bio)
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/edit/{id}', [ProfileController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ProfileController::class, 'update'])->name('update');
    });

    Route::get('/profile-picture', [ProfileController::class, 'show'])->name('profile.picture.show');
    Route::post('/profile-picture', [ProfileController::class, 'store'])->name('profile.picture.store');
});
