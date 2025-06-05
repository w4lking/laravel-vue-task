<?php

use App\Http\Controllers\TaskCategoryController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::resource('tasks', TaskController::class);
    Route::resource('task-categories', TaskCategoryController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
