<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OpacController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LibraryInfoController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\MemberManagementController;
use App\Http\Controllers\Admin\CirculationController;
use App\Http\Controllers\Admin\ReportController;

// Public routes
Route::get('/', [LibraryInfoController::class, 'index'])->name('home');
Route::get('/opac', [OpacController::class, 'index'])->name('opac.index');
Route::get('/opac/{book}', [OpacController::class, 'show'])->name('opac.show');
Route::get('/info', [LibraryInfoController::class, 'show'])->name('info');
Route::get('/events', [LibraryInfoController::class, 'events'])->name('events');

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Member routes (requires authentication and member role)
Route::middleware(['auth:member', 'guard.check:member'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [MemberController::class, 'profile'])->name('profile');
    Route::get('/history', [MemberController::class, 'history'])->name('history');
    Route::get('/fines', [MemberController::class, 'fines'])->name('fines');
    
    // Booking routes
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
    
    // Self-service borrow and return
    Route::post('/borrow', [MemberController::class, 'borrowBook'])->name('borrow');
    Route::post('/return/{transaction}', [MemberController::class, 'returnBook'])->name('return');
});

// Admin routes (requires authentication and admin/librarian role)
Route::middleware(['auth:admin', 'guard.check:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Book management
    Route::resource('books', BookController::class);
    Route::get('books/{book}/qrcode', [BookController::class, 'generateQR'])->name('books.qrcode');
    
    // Member management
    Route::resource('members', MemberManagementController::class);
    Route::get('members/{member}/qrcode', [MemberManagementController::class, 'generateQR'])->name('members.qrcode');
    
    // Borrowings Management
    Route::get('/borrowings', [App\Http\Controllers\Admin\BorrowingController::class, 'index'])->name('borrowings.index');
    Route::delete('/borrowings/{transaction}', [App\Http\Controllers\Admin\BorrowingController::class, 'destroy'])->name('borrowings.destroy');
    
    // Bookings Management
    Route::get('/bookings', [App\Http\Controllers\Admin\BookingManagementController::class, 'index'])->name('bookings.index');
    Route::delete('/bookings/{booking}', [App\Http\Controllers\Admin\BookingManagementController::class, 'destroy'])->name('bookings.destroy');
    
    // Transaction History
    Route::get('/transactions', [App\Http\Controllers\Admin\TransactionController::class, 'history'])->name('transactions.history');
    Route::get('/transactions/{transaction}/edit', [App\Http\Controllers\Admin\TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/transactions/{transaction}', [App\Http\Controllers\Admin\TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{transaction}', [App\Http\Controllers\Admin\TransactionController::class, 'destroy'])->name('transactions.destroy');
    
    // Circulation
    Route::post('/circulation/borrow', [CirculationController::class, 'borrow'])->name('circulation.borrow');
    Route::post('/circulation/return/{transaction}', [CirculationController::class, 'return'])->name('circulation.return');
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/{type}', [ReportController::class, 'export'])->name('reports.export');
});
