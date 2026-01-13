<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminLinkController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // --- DASHBOARD & PAGES (Inti Multi-Halaman) ---
    Route::get('/dashboard', [PageController::class, 'index'])->name('dashboard'); // Daftar Halaman
    Route::post('/pages', [PageController::class, 'store'])->name('pages.store'); // Buat Halaman Baru

    // Editor Tampilan Halaman (Pengganti BioController lama)
    Route::get('/dashboard/pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
    Route::put('/dashboard/pages/{page}', [PageController::class, 'update'])->name('pages.update');
    Route::delete('/pages/{page}', [PageController::class, 'destroy'])->name('pages.destroy');

    Route::controller(\App\Http\Controllers\ShortlinkController::class)->prefix('shortlinks')->name('shortlinks.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::delete('/{link}', 'destroy')->name('destroy');
        Route::patch('/{link}/toggle', 'toggle')->name('toggle');
    });

    // --- KELOLA LINK (Sekarang Terikat pada Page) ---
    Route::controller(LinkController::class)->group(function () {
        Route::get('/dashboard/pages/{page}/links', 'index')->name('links.index');
        Route::post('/dashboard/pages/{page}/links', 'store')->name('links.store');
        Route::put('/links/{link}', 'update')->name('links.update');
        Route::delete('/links/{link}', 'destroy')->name('links.destroy');
        Route::patch('/links/{link}/toggle', 'toggleStatus')->name('links.toggle');
        Route::get('/links/{id}/qr', 'generateQrCode')->name('links.qr');
        Route::post('/links/reorder', 'reorder')->name('links.reorder');
    });

    // --- PROFILE USER (Bawaan Breeze) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- ADMIN ROUTES ---
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        // USER MANAGEMENT
        Route::get('/users', [AdminUserController::class, 'index'])->name('users');
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        // LINK MANAGEMENT (GLOBAL)
        Route::get('/links', [AdminLinkController::class, 'index'])->name('links.index');
        Route::patch('/links/{link}/toggle', [AdminLinkController::class, 'toggle'])->name('links.toggle');
        Route::delete('/links/{link}', [AdminLinkController::class, 'destroy'])->name('links.destroy');
    });
});

require __DIR__ . '/auth.php';

// --- PUBLIC PAGE RESOLVER (Wajib Paling Bawah) ---
// Menangani domain.com/username atau domain.com/shortcode
Route::get('/go/{link}', [LinkController::class, 'go'])->name('links.go');
Route::get('/{path}', [LinkController::class, 'resolvePath'])->name('path.resolve');
