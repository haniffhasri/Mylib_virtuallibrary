<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Middleware\TrackVisitor;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\Admin\LibrarianValidationCodeController;

Route::get('/', function () {
    return view('welcome');
})->middleware(TrackVisitor::class);

Route::get('/send-mail', [RegisterController::class, 'create']);

// Logout
Route::get('logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Auth routes
Auth::routes();

// Landing Page
Route::get('/', [Controller::class, 'landingPage'])->name('welcome');

// Public Book Routes
Route::prefix('book')->name('book.')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('index');
    Route::get('/{id}', [BookController::class, 'show'])
        ->where('id', '[0-9]+')
        ->name('show');
    Route::get('/search', [BookController::class, 'search'])->name('search');
});


// support route
Route::get('/support', [SupportController::class, 'index'])->name('support.index');

// Forum Route
Route::middleware(['auth'])->group(function () {
    Route::get('/forum/create', [ForumController::class, 'create'])->name('forum.create');
    Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');
});
Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
Route::get('/forum/search', [ForumController::class, 'search'])->name('forum.search');
Route::get('/forum/{slug}', [ForumController::class, 'show'])->name('forum.show');

// thread
Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');

// Comments
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/comments/{id}', [CommentController::class, 'delete'])->name('comments.delete');
Route::post('/comments/update/{id}', [CommentController::class, 'update'])->name('comments.update');

// ContactUs
Route::get('/contact-us/{id}', [ContactController::class, 'show'])->name('contact-us.show');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');

    // Borrow
    Route::prefix('borrow')->name('borrow.')->group(function () {
        Route::get('/', [BorrowController::class, 'index'])->name('index');
        Route::get('/{id}', [BorrowController::class, 'borrow_book'])->name('book');
        Route::get('/show', [BorrowController::class, 'show'])->name('show');
    });

    // book rate
    Route::post('/book/{book}/rate', [BookController::class, 'rate'])->name('book.rate');

    // thread
    Route::post('/forum/{forum}/threads', [ThreadController::class, 'store'])->name('forum.threads.store');
    Route::get('/edit/{id}', [ThreadController::class, 'edit'])->name('forum.threads.edit');
    Route::post('/update/{id}', [ThreadController::class, 'update'])->name('forum.threads.update');
    Route::get('/delete/{id}', [ThreadController::class, 'delete'])->name('forum.threads.delete');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll'); 
    Route::get('/notifications/fetch', [NotificationController::class, 'fetch'])->name('notifications.fetch');

    // Profile (picture and bio)
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/edit/{id}', [ProfileController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ProfileController::class, 'update'])->name('update');
    });

    Route::get('/profile-picture', [ProfileController::class, 'show'])->name('profile.picture.show');
    Route::post('/profile-picture', [ProfileController::class, 'store'])->name('profile.picture.store');
});

// Admin and librarian route
Route::middleware(['auth', 'AdminLibrarianAccess'])->group(function () {
    // Book Routes (insert, update, delete, media actions)
    Route::prefix('book')->name('book.')->group(function () {
        Route::get('/insert', [BookController::class, 'create'])->name('create');
        Route::post('/', [BookController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [BookController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [BookController::class, 'update'])->name('update');
        Route::get('/destroy/{id}', [BookController::class, 'destroy'])->name('destroy');
        Route::delete('/{id}/delete-media', [BookController::class, 'deleteMedia'])->name('deleteMedia');
        Route::delete('/{id}/delete-image', [BookController::class, 'deleteImage'])->name('deleteImage');
    });

    // Borrow List
    Route::get('admin/borrow', [BorrowController::class, 'show'])->name('admin.borrow');

    // Borrow route
    Route::delete('borrow/delete/{id}', [BorrowController::class, 'delete'])->name('borrow.delete');

});

// Admin only route
Route::middleware(['auth', 'isAdmin'])->group(function () {
    // view User as Admin
    Route::get('/admin/user/search', [UserController::class, 'search'])->name('admin.user.search');
    Route::get('/admin/user/{id}', [DashboardController::class, 'viewUser'])->name('admin.view');
    Route::get('admin/user', [UserController::class, 'index'])->name('admin.user');
    Route::put('admin/update-role/{id}', [UserController::class, 'updateRole'])->name('user.updateRole');
    Route::delete('admin/delete/{id}', [UserController::class, 'delete'])->name('user.delete');

    // Admin - librarian code generator
    Route::get('/admin/codes', [LibrarianValidationCodeController::class, 'index'])->name('admin.codes.index');
    Route::post('/admin/codes', [LibrarianValidationCodeController::class, 'store'])->name('admin.codes.store');
    Route::delete('/admin/codes/{id}', [LibrarianValidationCodeController::class, 'destroy'])->name('admin.codes.destroy');

    // Admin - Analytics
    Route::get('/admin/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/admin/analytics/download', [AnalyticsController::class, 'downloadReport'])->name('analytics.download');

    // Admin support routes
    Route::get('/support/create', [SupportController::class, 'create'])->name('support.create');
    Route::post('/support', [SupportController::class, 'store'])->name('support.store');
    Route::delete('/support/{content}', [SupportController::class, 'destroy'])->name('support.destroy');
    Route::get('/support/{content}/edit', [SupportController::class, 'edit'])->name('support.edit');
    Route::put('/support/{content}', [SupportController::class, 'update'])->name('support.update');


    // Admin - Contact Us
    Route::post('/contact-us/update/{id}', [ContactController::class, 'update'])->name('contact-us.update');

    // backup route
    Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
    Route::post('/backup/create', [BackupController::class, 'create'])->name('backup.create');
    Route::get('/backup/download/{file}', [BackupController::class, 'download'])->name('backup.download');
    Route::post('/backup/restore/{file}', [BackupController::class, 'restore'])->name('backup.restore');

    // Admin - Contact Us
    Route::post('/contact-us/update/{id}', [ContactController::class, 'update'])->name('contact-us.update');
});