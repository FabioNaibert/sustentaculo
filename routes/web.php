<?php

use App\Http\Controllers\ChapterController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeaponController;
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

Route::get('/dashboard', [HistoryController::class, 'getHistories'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/history', [HistoryController::class, 'store'])->name('history.store');
    Route::get('/history/{id?}', [HistoryController::class, 'getHistory'])->name('history.get');

    Route::post('players', [PlayerController::class, 'getUsersToPlay'])->name('player.search');
    Route::post('add-player', [PlayerController::class, 'addPlayer'])->name('player.add');
    Route::post('remove-player', [PlayerController::class, 'removePlayer'])->name('player.remove');

    Route::post('add-enemy', [PlayerController::class, 'addEnemy'])->name('enemy.add');
    Route::post('remove-enemy', [PlayerController::class, 'removeEnemy'])->name('enemy.remove');

    Route::post('add-weapon', [WeaponController::class, 'addWeapon'])->name('weapon.add');
    Route::post('remove-weapon', [WeaponController::class, 'removeWeapon'])->name('weapon.remove');

    Route::post('add-image', [ImageController::class, 'addImage'])->name('image.add');
    Route::post('remove-image', [ImageController::class, 'removeImage'])->name('image.remove');
});

require __DIR__.'/auth.php';
