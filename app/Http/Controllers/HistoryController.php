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
    public function getHistories()
    {
        $user = Auth::user();

        $histories = History::with('firstChapter')->where('master_id', $user->id)->get();

        return $histories;
    }

    public function getHistory($id)
    {
        $history = History::find($id);
        $chapters = Chapter::where('history_id', $id)->get();
        $players = Player::where([
                ['history_id', $id],
                ['user_id', '!=', $history->master_id]
            ])
            ->get()
            ->map(fn ($player) => [
                'id' => $player->id,
                'name' => $player->name,
                'attributes' => $player->attributesPoints->map(function ($attributesPoints) {
                    $attribute = $attributesPoints->attribute;
                    return [
                        'totalPoints' => $attributesPoints->total_points,
                        'currentPoints' => $attributesPoints->current_points,
                        'id' => $attribute->id,
                        'name' => $attribute->name,
                        'representationColor' => $attribute->representation_color,
                    ];
                })
            ]);

        $enemies = Player::where([
                ['history_id', $id],
                ['user_id', $history->master_id]
            ])
            ->get()
            ->map(fn ($enemy) => [
                'id' => $enemy->id,
                'name' => $enemy->name,
                'attributes' => $enemy->attributesPoints->map(function ($attributesPoints) {
                    $attribute = $attributesPoints->attribute;
                    return [
                        'totalPoints' => $attributesPoints->total_points,
                        'currentPoints' => $attributesPoints->current_points,
                        'id' => $attribute->id,
                        'name' => $attribute->name,
                        'representationColor' => $attribute->representation_color,
                    ];
                })
            ]);

        $allHistory = [
            'history' => [
                'id' => $history->id,
                'title' => $history->title,
                'masterId' => $history->master_id,
                'chapters' => $chapters,
                'players' => $players,
                'enemies' => $enemies
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
