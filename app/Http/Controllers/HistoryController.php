<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Chapter;
use App\Models\History;
use App\Models\Player;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class HistoryController extends Controller
{
    private PlayerController $playerController;
    private WeaponController $weaponController;


    public function __construct(PlayerController $playerController, WeaponController $weaponController)
    {
        $this->playerController = $playerController;
        $this->weaponController = $weaponController;
    }


    public function getHistories()
    {
        $user = Auth::user();

        $histories = History::with('firstChapter')->where('master_id', $user->id)->get();

        return Inertia::render('Dashboard', [
            'histories' => $histories
        ]);
    }

    public function getHistory($id)
    {
        $history = History::find($id);
        $chapters = Chapter::where('history_id', $id)->get();
        $players = $this->playerController->getPlayers($history->id, $history->master_id);
        $enemies = $this->playerController->getEnemies($history->id, $history->master_id);
        $weapons = $this->weaponController->getWeapons($history->id);

        $allHistory = [
            'history' => [
                'id' => $history->id,
                'title' => $history->title,
                'masterId' => $history->master_id,
                'chapters' => $chapters,
                'players' => $players,
                'enemies' => $enemies,
                'weapons' => $weapons
            ],
            'allAttributes' => Attribute::all(['id', 'name'])->map(fn ($attribute) => [
                'id' => $attribute->id,
                'name' => $attribute->name,
                'totalPoints' => null
            ])
        ];

        return Inertia::render('History', [
            'response' => $allHistory,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:255'],
        ]);

        $user = Auth::user();

        History::create([
            'master_id' => $user->id,
            'title' => $request->input('title')
        ]);
    }
}
