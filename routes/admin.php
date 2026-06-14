<?php 

use App\Http\Controllers\Admin\AboutMeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\MessageController;

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::patch('/admin/projects/reorder', [ProjectController::class, 'reorder']);
    Route::patch('/admin/skills/reorder', [SkillController::class, 'reorder']);
    Route::patch('/admin/experiences/reorder', [ExperienceController::class, 'reorder']);
    Route::resource('/admin/projects', ProjectController::class);
    Route::resource('/admin/skills', SkillController::class);
    Route::resource('/admin/experiences', ExperienceController::class);
    Route::resource('/admin/about-me', AboutMeController::class);
    Route::resource('/admin/messages', MessageController::class)->only(['index', 'show', 'update', 'destroy']);
});