<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// normal users cant create accounts
Auth::routes(['register' => false]);




// Admin-only
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin manages users
    Route::resource('/users', App\Http\Controllers\UserController::class)->except(['show']);

    // route to force-logout a user by admin
    Route::post('/users/{user}/force-logout', [App\Http\Controllers\UserController::class, 'forceLogout'])
    ->name('users.force-logout');

    // Soft-deleted users (trash)
    Route::get('/users-trash', [App\Http\Controllers\UserController::class, 'trash'])->name('users.trash');
    Route::post('/users/{id}/restore', [App\Http\Controllers\UserController::class, 'restore'])->name('users.restore');
    Route::delete('/users/{id}/force-delete', [App\Http\Controllers\UserController::class, 'forceDelete'])->name('users.force-delete');
});

// Manager + Admin routes
Route::middleware(['auth', 'role:admin,manager'])->group(function () {
    // ...
});

// Collector-only routes
Route::middleware(['auth', 'role:collector'])->group(function () {
    // ...
});

// Biller-only routes
Route::middleware(['auth', 'role:biller'])->group(function () {
    // ...
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'profileUpdate'])->name('profile.update');

    // auto logout route
    Route::get('/auto-logout', function (Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('error', 'You have been logged out due to inactivity.');
    })->name('auto.logout');

    Route::get('/', [App\Http\Controllers\HomeController::class, 'root']);
    Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
});

