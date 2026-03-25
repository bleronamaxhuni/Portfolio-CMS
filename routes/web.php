<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\IndexController;

Route::get('/', [IndexController::class,'index'])->name('home');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/storage/about/{path}', function (string $path) {
    $path = ltrim($path, '/');
    $diskPath = 'about/' . $path;

    abort_unless(Storage::disk('public')->exists($diskPath), 404);

    
    $absolutePath = Storage::disk('public')->path($diskPath);

    abort_unless(is_file($absolutePath), 404);

    return response()->file($absolutePath);
})->where('path', '.*');
