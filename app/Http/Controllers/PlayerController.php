<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Player;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlayerController extends Controller
{
    public function getPlayers(Request $request)
    {
        $name = $request->input('name');
        $historyId = $request->input('history_id');

        return $this->queryPlayers($name, $historyId);
    }


    public function queryPlayers($name, $historyId)
    {
        if (!$name) return [];

        $masterId = auth()->user()->id;
        $historyId = $historyId;
        $existingPlayers = Player::where('history_id', $historyId)->get()->pluck('user_id');

        $query = User::where('id', '!=', $masterId)
            ->whereRaw("upper(name) like upper('$name%')");

        if ($existingPlayers->isNotEmpty()) {
            $query->whereNotIn('id', $existingPlayers);
        }

        return $query->get();
    }


    public function addPlayer(Request $request)
    {
        $userId = $request->input('user_id');
        $historyId = $request->input('history_id');
        $points = $request->input('points');

        $user = User::find($userId);

        $player = Player::create([
            'name' => $user->name,
            'user_id' => $user->id,
            'history_id' => $historyId,
            'points_distribution' => $points,
        ]);

        $attributes = Attribute::all()->pluck('id');

        $player->attributes()->attach($attributes);

        return null;
    }


    public function addEnemy(Request $request)
    {
        $historyId = $request->input('history_id');
        $allAttributes = $request->input('all_attributes');
        $name = $request->input('name');
        $masterId = auth()->user()->id;

        $enemy = Player::create([
            'name' => $name,
            'user_id' => $masterId,
            'history_id' => $historyId,
        ]);

        $mapAttributes = collect($allAttributes)->mapWithKeys(function ($attribute) {
            return [
                $attribute['id'] => [
                    'total_points' => $attribute['totalPoints']
                ]
            ];
        });

        $enemy->attributes()->attach($mapAttributes);

        return null;
    }
}
