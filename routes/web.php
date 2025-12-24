<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BioController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\AdminUserController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Routes (Bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route Manajemen User (Admin)
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [App\Http\Controllers\AdminUserController::class, 'index'])->name('users');
    });

    // Route Fitur Kelola Link
    Route::controller(LinkController::class)->group(function () {
        Route::get('/links', 'index')->name('links.index');
        Route::post('/links', 'store')->name('links.store');
        Route::delete('/links/{id}', 'destroy')->name('links.destroy');
    });

    // Route Fitur Bio
    Route::controller(BioController::class)->group(function () {
        Route::get('/bio', 'index')->name('bio.index');
    });
});

require __DIR__ . '/auth.php';
Route::get('/@{username}', [BioController::class, 'show'])->name('bio.show');
Route::get('/{code}', [App\Http\Controllers\LinkController::class, 'redirect'])->name('shortlink.redirect');