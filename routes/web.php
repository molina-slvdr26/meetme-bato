<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MeetingNoteController; 
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::get('/', fn() => redirect()->route('login'));
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});


Route::middleware('auth')->group(function () {
    
  
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    
    Route::get('/meeting-notes', [MeetingNoteController::class, 'index'])->name('notes.index');
    Route::post('/meeting-notes', [MeetingNoteController::class, 'store'])->name('notes.store');
    Route::put('/meeting-notes/{id}', [MeetingNoteController::class, 'update'])->name('notes.update');
    Route::delete('/meeting-notes/{id}', [MeetingNoteController::class, 'destroy'])->name('notes.destroy');
   
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});