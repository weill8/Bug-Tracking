<?php

use App\Models\Bugs;
use App\Models\User;
use App\Models\Projects;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BugsController;
use App\Http\Controllers\BugLogsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserRewardsController;
use App\Http\Controllers\BugAttachmentsController;

Route::get('/', function () {
    $jumlahUser = User::count();
    $jumlahProject = Projects::count();
    $jumlahResolved = Bugs::where('status', 'Resolved')->count();

    return view('welcome', compact('jumlahUser', 'jumlahProject', 'jumlahResolved'));
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('projects', ProjectsController::class);
    Route::resource('bugs', BugsController::class);
    Route::resource('bugLogs', BugLogsController::class);
    Route::resource('bugAttachments', BugAttachmentsController::class);
    Route::resource('userRewards', UserRewardsController::class);
});

require __DIR__.'/auth.php';
