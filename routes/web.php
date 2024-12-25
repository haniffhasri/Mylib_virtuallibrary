<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Auth::routes();

Route::get('/borrow', [BorrowController::class,'index'])->name('borrow.index');

Route::get('/borrow/{id}', [BorrowController::class, 'borrow_book'])->name('borrow_book');

Route::get('/borrow/delete/{id}', [BorrowController::class, 'delete'])->name('book.delete');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/book', [BookController::class,'index'])->name('book.index');

Route::get('/book/insertion', [BookController::class, 'create'])->name('book.create');

Route::get('/book/{id}', [BookController::class, 'show'])->name('book.show');

Route::get('/book/destroy/{id}', [BookController::class, 'destroy'])->name('book.destroy');

Route::get('/book/edit/{id}', [BookController::class, 'edit'])->name('book.edit');

Route::post('/book/update/{id}', [BookController::class, 'update'])->name('book.update');

Route::post('/book', [BookController::class, 'store'])->name('book.store');

// Route::get('/books/{id}/image', [BookController::class, 'showImage'])->name('books.image');

// Route::get('/book/{id}/pdf', [BookController::class, 'showPDF'])->name('books.pdf');

// admin
Route::get('/admin', [DashboardController::class,'index'])->name('admin.index');

