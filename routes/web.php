<?php

use App\Http\Controllers\ChapterController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SoundController;
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

Route::get('/dashboard', function () {return Inertia::render('Dashboard');})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/histories', [HistoryController::class, 'getHistoriesDesktop'])->name('histories.desktop.get');

    Route::get('/m-histories', [HistoryController::class, 'getHistoriesMobile'])->name('histories.mobile.get');
    Route::get('/m-game/{player_id?}', [HistoryController::class, 'getGameMobile'])->name('game.mobile.get');
    Route::get('/m-resources', [ImageController::class, 'getImagesPlayer'])->name('resources.mobile.get');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/game/{id?}/{chapter?}', [HistoryController::class, 'getGameByChapter'])->name('game.desktop.get');
    Route::post('/game/previous', [ChapterController::class, 'previousGameChapter'])->name('game.previous.get');
    Route::post('/game/next', [ChapterController::class, 'nextGameChapter'])->name('game.next.get');

    Route::post('/history', [HistoryController::class, 'store'])->name('history.store');
    Route::get('/history/{id?}', [HistoryController::class, 'getHistory'])->name('history.get');
    Route::post('/history-edit-title', [HistoryController::class, 'editHistoryTitle'])->name('history.edit.title');

    Route::post('players', [PlayerController::class, 'getUsersToPlay'])->name('player.search');
    Route::post('add-player', [PlayerController::class, 'addPlayer'])->name('player.add');
    Route::post('remove-player', [PlayerController::class, 'removePlayer'])->name('player.remove');

    Route::post('add-enemy', [PlayerController::class, 'addEnemy'])->name('enemy.add');
    Route::post('remove-enemy', [PlayerController::class, 'removeEnemy'])->name('enemy.remove');

    Route::post('add-weapon', [WeaponController::class, 'addWeapon'])->name('weapon.add');
    Route::post('remove-weapon', [WeaponController::class, 'removeWeapon'])->name('weapon.remove');
    Route::post('share-weapon', [WeaponController::class, 'shareWeapon'])->name('weapon.share');
    Route::post('equip-weapon', [WeaponController::class, 'equipWeapon'])->name('weapon.equip');

    Route::post('add-image', [ImageController::class, 'addImage'])->name('image.add');
    Route::post('remove-image', [ImageController::class, 'removeImage'])->name('image.remove');
    Route::post('share-image', [ImageController::class, 'shareImage'])->name('image.share');

    Route::post('add-chapter', [ChapterController::class, 'addChapter'])->name('chapter.add');
    Route::post('edit-chapter', [ChapterController::class, 'editChapter'])->name('chapter.edit');
    Route::post('previous-chapter', [ChapterController::class, 'previousChapter'])->name('chapter.previous');
    Route::post('next-chapter', [ChapterController::class, 'nextChapter'])->name('chapter.next');
    Route::post('remove-chapter', [ChapterController::class, 'removeChapter'])->name('chapter.remove');

    Route::post('search-sound', [SoundController::class, 'getSounds'])->name('sound.search');
    Route::post('add-sound', [SoundController::class, 'addSound'])->name('sound.add');
    Route::post('remove-sound', [SoundController::class, 'removeSound'])->name('sound.remove');

    Route::post('socketi_teste', [HistoryController::class, 'socketiTeste'])->name('socketi.teste');
});

require __DIR__.'/auth.php';
