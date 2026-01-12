<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProcrumentRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierEvaluationController;
use App\Http\Controllers\UserController;
use App\Models\SupplierEvaluation;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::resource('users', UserController::class);
    Route::resource('procrument-request', ProcrumentRequestController::class);
    Route::patch('procrument/{id}/approve', [ProcrumentRequestController::class, 'approve'])->name('procurement.approve');
    Route::patch('procrument/{id}/reject', [ProcrumentRequestController::class, 'reject'])->name('procurement.reject');

    Route::resource('suppliers', SupplierController::class);
    Route::resource('supplier_evaluation', SupplierEvaluationController::class);

    Route::post('settings', [SettingController::class, 'store'])->name('settings.store');
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
