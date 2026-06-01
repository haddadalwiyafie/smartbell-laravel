<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('dashboard'));

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/audio', [AudioController::class, 'index'])->name('audio');
    Route::post('/audio/upload', [AudioController::class, 'upload'])->name('audio.upload');
    Route::delete('/audio/{audioTrack}', [AudioController::class, 'destroy'])->name('audio.destroy');

    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule');
    Route::post('/schedule', [ScheduleController::class, 'store'])->name('schedule.store');
    Route::put('/schedule/{bellSchedule}', [ScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('/schedule/{bellSchedule}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');
    Route::patch('/schedule/{bellSchedule}/toggle', [ScheduleController::class, 'toggleStatus'])->name('schedule.toggle');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings/general', [SettingsController::class, 'updateGeneral'])->name('settings.general');
    Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile');
});
