<?php

use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BioController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\AdminUserController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        /** @var \App\Models\User $user */
        $user = Illuminate\Support\Facades\Auth::user();
        $totalShortlinks = $user->links()->where('type', 'shortlink')->count();
        $totalBiolinks   = $user->links()->where('type', 'biolink')->count();
        $totalClicks     = $user->links()->sum('click_count');
        $totalUsers = 0;
        if ($user->role === 'admin') {
            $totalUsers = User::count();
        }

        $popularLinks = $user->links()
            ->orderByDesc('click_count')
            ->limit(5)
            ->get();

        return view('dashboard', compact('totalShortlinks', 'totalBiolinks', 'totalClicks', 'popularLinks', 'user', 'totalUsers'));
    })->middleware(['auth', 'verified'])->name('dashboard');

    // Profile Routes (Bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route Manajemen User (Admin)
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [AdminUserController::class, 'index'])->name('users');
        Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    });

    // Route Fitur Kelola Link
    Route::controller(LinkController::class)->group(function () {
        Route::get('/links', 'index')->name('links.index');
        Route::post('/links', 'store')->name('links.store');
        Route::delete('/links/{id}', 'destroy')->name('links.destroy');
        Route::get('/links/{id}/qr', 'generateQrCode')->name('links.qr');
    });

    // Route Fitur Bio
    Route::controller(BioController::class)->group(function () {
        Route::get('/bio', 'index')->name('bio.index');
        Route::post('/bio/profile', 'updateProfile')->name('bio.update.profile');
        Route::post('/bio/link', 'store')->name('bio.link.store');
        Route::delete('/bio/link/{id}', 'destroy')->name('bio.link.destroy');
        Route::put('/bio/link/{id}', 'updateLink')->name('bio.link.update');
    });
});

require __DIR__ . '/auth.php';
Route::get('/@{username}', [BioController::class, 'show'])->name('bio.show');
Route::get('/{path}', [App\Http\Controllers\LinkController::class, 'resolvePath'])->name('path.resolve');