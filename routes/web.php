<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\IndexController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\PortfolioController;

Route::get('/', [IndexController::class,'index'])->name('home');
Route::get('/api/portfolio', [PortfolioController::class, 'index'])->name('api.portfolio');


// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Contact Routes
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/contact', function () {
    return redirect()->to(route('home').'#contact');
})->name('contact.page');