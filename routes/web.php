<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\OccupancyController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest','verified'])->get('/', function () {
    return view('auth.login');
});

Route::prefix('staff')->name('staff.')->middleware(['auth', 'verified', 'role:1'])->group(function () {

    Route::get('/dashboard', function () {
        return view('staff.dashboard');
    })->name('dashboard');

    Route::get('/monitor', function () {
        return view('staff.monitor');
    })->name('monitor');
    
    Route::get('/report', [OccupancyController::class, 'index'])->name('report');

    Route::get('/account', [AccountController::class, 'index'])->name('account');
    
    Route::patch('/account/update/{id}', [AccountController::class, 'store'])->name('update.account');
    Route::post('/account/add', [AccountController::class, 'add'])->name('add.account');
    Route::delete('/account/delete/{id}', [AccountController::class, 'delete'])->name('delete.account');

});

Route::prefix('student')->name('student.')->middleware(['auth', 'verified', 'role:0'])->group(function () {

    Route::get('/dashboard', function () {
        return view('student.dashboard');
    })->name('dashboard');
    
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
