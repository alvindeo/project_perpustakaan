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
Route::middleware(['auth', 'role:member'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [MemberController::class, 'profile'])->name('profile');
    Route::get('/history', [MemberController::class, 'history'])->name('history');
    Route::get('/fines', [MemberController::class, 'fines'])->name('fines');
    
    // Booking routes
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
});

// Admin routes (requires authentication and admin/librarian role)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Book management
    Route::resource('books', BookController::class);
    Route::get('books/{book}/qrcode', [BookController::class, 'generateQR'])->name('books.qrcode');
    
    // Member management
    Route::resource('members', MemberManagementController::class);
    Route::get('members/{member}/qrcode', [MemberManagementController::class, 'generateQR'])->name('members.qrcode');
    
    // Circulation
    Route::get('/circulation/borrow', [CirculationController::class, 'borrowForm'])->name('circulation.borrow');
    Route::post('/circulation/borrow', [CirculationController::class, 'processBorrow'])->name('circulation.process-borrow');
    Route::get('/circulation/return', [CirculationController::class, 'returnForm'])->name('circulation.return');
    Route::post('/circulation/return', [CirculationController::class, 'processReturn'])->name('circulation.process-return');
    Route::get('/circulation/history', [CirculationController::class, 'history'])->name('circulation.history');
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/popular-books', [ReportController::class, 'popularBooks'])->name('reports.popular-books');
    Route::get('/reports/overdue', [ReportController::class, 'overdue'])->name('reports.overdue');
    Route::get('/reports/fines', [ReportController::class, 'fines'])->name('reports.fines');
    Route::get('/reports/export/{type}', [ReportController::class, 'export'])->name('reports.export');
});
