<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'role:SuperAdmin'])->name('dashboard');

Route::middleware(['auth', 'role:SuperAdmin'])->group(function () {
    Route::resource('user', UserController::class); // User Management

    /** Submission Role Route */
    Route::get('/sumission-role/all', [UserController::class, 'indexSubmission'])->name('submission.role.index');
    Route::get('/submission-role', [UserController::class, 'pendingSubmission'])->name('submission.role.pending');
    Route::get('/submission-role/{pendings}', [UserController::class, 'showSubmission'])->name('submission.role.show');
    Route::post('/submission-role/{userId}/{id}', [UserController::class, 'approveSubmission'])->name('submission.role.approve');
    Route::post('/submission-role/{id}', [UserController::class, 'declineSubmission'])->name('submission.role.decline');
    /** End Submission Role Route */

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
