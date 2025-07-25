<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\MajelisController;
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
    Route::resource('users', UserController::class); // User Management
    Route::resource('events', EventController::class);
    Route::resource('majelis', MajelisController::class);

    /** Majelis Route */
    Route::patch('/majelis/{majelis}/change-status', [MajelisController::class, 'changeStatus'])->name('changestatus.majelis');
    Route::get('/presences-majelis', [MajelisController::class, 'indexPresences'])->name('presences.index');
    Route::post('/presences-majelis/get-data', [MajelisController::class, 'getPresencesData'])->name('presences.getdata');
    Route::get('/presences-majelis/show/{userId}', [MajelisController::class, 'showPresencesUser'])->name('presences.show');
    Route::delete('/presences-majelis/{presence}', [MajelisController::class, 'destroyPresence'])->name('presences.destroy');
    /** End Majelis Route */

    /** Submission Role Route */
    Route::get('/sumission-role/all', [UserController::class, 'indexSubmission'])->name('submission.role.index');
    Route::get('/submission-role', [UserController::class, 'pendingSubmission'])->name('submission.role.pending');
    Route::get('/submission-role/{pendings}', [UserController::class, 'showSubmission'])->name('submission.role.show');
    Route::post('/submission-role/{userId}/{id}', [UserController::class, 'approveSubmission'])->name('submission.role.approve');
    Route::post('/submission-role/{id}', [UserController::class, 'declineSubmission'])->name('submission.role.decline');
    /** End Submission Role Route */

    /** Submission Events Route */
    Route::get('/sumission-event/pending', [EventController::class, 'submissionEvent'])->name('submission.event.index');
    /** End Submission Events Route */

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
