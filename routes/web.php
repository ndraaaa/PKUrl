<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PageController;
use App\Http\Controllers\PageLinkController;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashboardController;

Route::view('/', 'welcome')->name('home');
Route::post('/guest/shorten', [ShortLinkController::class, 'storePublic'])->name('guest.shorten');
Route::get('/guest/qr/{shortCode}', [ShortLinkController::class, 'showPublicQr'])->name('guest.qr');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chart');

    Route::get('/pages', [PageController::class, 'index'])->name('pages.index');

    // --- A. CRUD Halaman (Page) ---
    Route::post('/pages', [PageController::class, 'store'])->name('pages.store');
    Route::get('/pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
    Route::put('/pages/{page}', [PageController::class, 'update'])->name('pages.update');
    Route::delete('/pages/{page}', [PageController::class, 'destroy'])->name('pages.destroy');

    // --- B. PAGE LINKS (TOMBOL DI DALAM BIO) ---
    Route::post('/pages/{page}/links', [PageLinkController::class, 'store'])->name('page-links.store');
    Route::put('/links/{link}', [PageLinkController::class, 'update'])->name('page-links.update');
    Route::delete('/links/{link}', [PageLinkController::class, 'destroy'])->name('page-links.destroy');
    Route::post('/links/reorder', [PageLinkController::class, 'reorder'])->name('links.reorder');

    // --- C. SHORTLINK (LINK PENDEK BIASA) ---
    Route::resource('shortlinks', ShortLinkController::class)->except(['create', 'show', 'edit']);
    Route::get('/shortlinks/{link}/qr-code', [ShortLinkController::class, 'generateQrWithLogo'])->name('shortlinks.qr');
    Route::post('/shortlinks/bulk-destroy', [ShortLinkController::class, 'bulkDestroy'])->name('shortlinks.bulk_destroy');

    // --- D. PROFILE USER (Setting Akun) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- E. ADMIN AREA ---
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
        Route::get('/links', [App\Http\Controllers\AdminLinkController::class, 'index'])->name('links.index');
        Route::post('/links/{link}/toggle', [App\Http\Controllers\AdminLinkController::class, 'toggleStatus'])->name('links.toggle');
        Route::delete('/links/{link}', [App\Http\Controllers\AdminLinkController::class, 'destroy'])->name('links.destroy');
    });
});

require __DIR__ . '/auth.php';
Route::get('/{path}', [RedirectController::class, 'handle'])->name('public.redirect');
