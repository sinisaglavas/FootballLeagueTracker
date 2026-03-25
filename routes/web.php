<?php

use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteTeamController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/competitions', [CompetitionController::class, 'index'])->name('competitions.index');
    Route::get('/competitions/{code}', [CompetitionController::class, 'standings'])->name('competitions.standings');
    Route::get('/competitions/{code}/matches', [CompetitionController::class, 'matches'])->name('competitions.matches');
    Route::get('/teams/{id}', [CompetitionController::class, 'show'])->name('competitions.show');

    Route::post('/favorite-teams', [FavoriteTeamController::class, 'store'])->name('favorite-teams.store');
    Route::delete('/favorite-teams/{favoriteTeam}', [FavoriteTeamController::class, 'destroy'])->name('favorite-teams.destroy');
    Route::patch('/favorite-teams/{id}/restore', [FavoriteTeamController::class, 'restore'])->name('favorite-teams.restore');
    Route::delete('/favorite-teams/{id}/force-delete', [FavoriteTeamController::class, 'forceDelete'])->name('favorite-teams.force-delete');
});

require __DIR__.'/auth.php';
