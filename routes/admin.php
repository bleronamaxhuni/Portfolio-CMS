<?php 

use App\Http\Controllers\Admin\AboutMeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SkillController;

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('/admin/projects', ProjectController::class);
    Route::resource('/admin/skills', SkillController::class);
    Route::resource('/admin/experiences', ExperienceController::class);
    Route::resource('/admin/about-me', AboutMeController::class);
});