<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ReversionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserBorrowingController;
use App\Http\Controllers\UserReversionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;

Route::get('/', [AuthController::class, 'showLogin'])->name('auths.login');
Route::post('/login', [AuthController::class, 'login'])->name('auths.login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('auths.register');
Route::post('/register', [AuthController::class, 'register'])->name('auths.register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('auths.logout');

// Shared Auth Routes for both Admin and User
Route::middleware('auth')->group(function () {
    // Notifications
    Route::get('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/notifications', [NotificationController::class, 'destroyAll'])->name('notifications.destroyAll');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard-admin', [HomeController::class, 'dashboardAdmin'])->name('dashboard.admin');
    
    Route::resource('users', UserController::class);
    Route::get('/books/search', [BookController::class, 'search'])->name('books.search');
    Route::resource('books', BookController::class)->except(['show']);
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
    
    // Borrowings logic for Admin (Approval)
    Route::get('/borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
    Route::post('/borrowings/{borrowing}/approve', [BorrowingController::class, 'approve'])->name('borrowings.approve');
    Route::post('/borrowings/{borrowing}/reject', [BorrowingController::class, 'reject'])->name('borrowings.reject');
    
    // Reversions logic for Admin (Verification)
    Route::get('/reversions', [ReversionController::class, 'index'])->name('reversions.index');
    Route::post('/reversions/{borrowing_id}/approve', [ReversionController::class, 'approveReturn'])->name('reversions.approve');
    Route::post('/reversions/{borrowing_id}/reject', [ReversionController::class, 'rejectReturn'])->name('reversions.reject');
});

// User Routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard-user', [HomeController::class, 'dashboardUser'])->name('users.dashboard');
    
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show.user');
    
    Route::get('/user/borrowings', [UserBorrowingController::class, 'index'])->name('user.borrowings.index');
    Route::get('/user/borrowings/{book_id}/create', [UserBorrowingController::class, 'create'])->name('user.borrowings.create');
    Route::post('/user/borrowings', [UserBorrowingController::class, 'store'])->name('user.borrowings.store');
    
    Route::get('/user/reversions', [UserReversionController::class, 'index'])->name('user.reversions.index');
    Route::post('/user/reversions/{borrowing_id}', [UserReversionController::class, 'store'])->name('user.reversions.store');
});
