<?php

use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/competitions', [CompetitionController::class, 'index'])->name('competitions.index');
Route::get('/competitions/{code}', [CompetitionController::class, 'standings'])->name('competitions.standings');
Route::get('/competitions/{code}/matches', [CompetitionController::class, 'matches'])->name('competitions.matches');
Route::get('/teams/{id}', [CompetitionController::class, 'show'])->name('competitions.show');

require __DIR__.'/auth.php';
