<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BioController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\AdminUserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    // Route Fitur Link-in-Bio
    Route::controller(BioController::class)->group(function () {
        Route::get('/bio', 'index')->name('bio.index');       // Halaman lihat/edit bio
        Route::post('/bio/update', 'update')->name('bio.update'); // Proses simpan (nanti)
    });

    // Route Fitur Shortener
    Route::controller(LinkController::class)->group(function () {
        Route::get('/links', 'index')->name('links.index');   // Halaman list link
        Route::post('/links', 'store')->name('links.store');  // Proses perpendek link (nanti)
    });
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminUserController::class, 'index'])->name('users');
});

Route::controller(LinkController::class)->group(function () {
    Route::get('/links', 'index')->name('links.index');
    Route::post('/links', 'store')->name('links.store');
    Route::delete('/links/{id}', 'destroy')->name('links.destroy'); // Tambahan hapus
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/{code}', [App\Http\Controllers\LinkController::class, 'redirect'])->name('shortlink.redirect');
require __DIR__ . '/auth.php';
