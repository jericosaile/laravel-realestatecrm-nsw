<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PropertyController;


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

// Public Routes
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup']);

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
    Route::get('/dashboard', [PropertyController::class, 'index'])->name('dashboard');
    Route::resource('properties', PropertyController::class);
    Route::get('/properties/{property}/payment', [PaymentController::class, 'create'])->name('properties.payment');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::post('/properties/{id}/generate-payments', [PaymentController::class, 'generateSchedule'])->name('payments.generate');
    Route::delete('/payments/{id}', [PaymentController::class, 'destroy'])->name('payments.destroy');

});





