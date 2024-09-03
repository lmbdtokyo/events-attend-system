<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/organization',  [App\Http\Controllers\OrganizationController::class, 'index'])->name('organization.index');
Route::get('/organization/create',  [App\Http\Controllers\OrganizationController::class, 'create'])->name('organization.create');
Route::post('/organization/store', [App\Http\Controllers\OrganizationController::class, 'store'])->name('organization.store');
Route::patch('/organization/{id}', [App\Http\Controllers\OrganizationController::class, 'update'])->name('organization.update');
Route::get('/organization/{id}',  [App\Http\Controllers\OrganizationController::class, 'edit'])->name('organization.edit');
Route::delete('/organization/destroy/{id}', [App\Http\Controllers\OrganizationController::class, 'destroy'])->name('organization.destroy');


Route::middleware('auth')->group(function () {
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    Route::get('/users/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
    Route::patch('/users/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
    Route::delete('/users/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
    Route::post('/users/store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
