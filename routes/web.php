<?php

use App\Http\Controllers\ChapterController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'histories' => (new HistoryController)->getHistories()
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/history', [HistoryController::class, 'store'])->name('history.store');
    Route::get('/history/{id?}', [HistoryController::class, 'getHistory'])->name('history.get');

    Route::post('players', [PlayerController::class, 'getUsersToPlay'])->name('player.search');
    Route::post('add-player', [PlayerController::class, 'addPlayer'])->name('player.add');

    Route::post('add-enemy', [PlayerController::class, 'addEnemy'])->name('enemy.add');
});

require __DIR__.'/auth.php';
