<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\InsightController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgressController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/meals', [MealController::class, 'index'])->name('meals.index');
    Route::get('/meals/create', [MealController::class, 'create'])->name('meals.create');
    Route::post('/meals', [MealController::class, 'store'])->name('meals.store');
    Route::delete('/meals/{meal}', [MealController::class, 'destroy'])->name('meals.destroy');
    Route::get('/foods/search', [MealController::class, 'searchFood'])->name('foods.search');

    Route::get('/habits', [HabitController::class, 'index'])->name('habits.index');
    Route::post('/habits', [HabitController::class, 'store'])->name('habits.store');
    Route::delete('/habits/{habit}', [HabitController::class, 'destroy'])->name('habits.destroy');
    Route::post('/habits/{habit}/log', [HabitController::class, 'log'])->name('habits.log');
    Route::delete('/habits/{habit}/log', [HabitController::class, 'unlog'])->name('habits.unlog');

    Route::get('/progress', ProgressController::class)->name('progress');

    Route::get('/insights', [InsightController::class, 'index'])->name('insights.index');
    Route::post('/insights/generate', [InsightController::class, 'generate'])->name('insights.generate');
    Route::patch('/insights/{insight}/read', [InsightController::class, 'markRead'])->name('insights.read');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
