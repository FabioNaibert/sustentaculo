<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\History;
use App\Models\Player;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlayerController extends Controller
{
    public function getUsersToPlay(Request $request)
    {
        $name = $request->input('name');
        $historyId = $request->input('history_id');

        return $this->getUsers($name, $historyId);
    }


    public function getUsers($name, $historyId)
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
        $history = History::find($historyId);

        $player = Player::create([
            'name' => $user->name,
            'user_id' => $user->id,
            'history_id' => $historyId,
            'points_distribution' => $points,
        ]);

        $attributes = Attribute::all()->pluck('id');

        $player->attributes()->attach($attributes);

        return $this->getPlayers($history->id, $history->master_id);
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
            if (Attribute::hasCurrentPoints($attribute['id'])) {
                $data = [
                    'total_points' => $attribute['totalPoints'],
                    'current_points' => $attribute['totalPoints']
                ];
            } else {
                $data = [
                    'total_points' => $attribute['totalPoints'],
                    'current_points' => null
                ];
            }

            return [
                $attribute['id'] => $data
            ];
        });

        Log::info($mapAttributes);

        $enemy->attributes()->attach($mapAttributes);

        return $this->getEnemies($historyId, $masterId);
    }


    public function getPlayers($historyId, $masterId)
    {
        $userIsNotMaster = '!=';
        return $this->mapPlayers($historyId, $masterId, $userIsNotMaster);
    }

    public function getEnemies($historyId, $masterId)
    {
        $userIsMaster = '=';
        return $this->mapPlayers($historyId, $masterId, $userIsMaster);
    }


    public function mapPlayers($historyId, $masterId, $condition)
    {
        return Player::where([
                ['history_id', $historyId],
                ['user_id', $condition, $masterId]
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
    }


    public function removePlayer(Request $request)
    {
        $playerId = $request->input('player_id');
        $historyId = $request->input('history_id');
        $history = History::find($historyId);

        $this->removeUser($playerId);

        return $this->getPlayers($history->id, $history->master_id);
    }


    public function removeEnemy(Request $request)
    {
        $playerId = $request->input('player_id');
        $historyId = $request->input('history_id');
        $history = History::find($historyId);

        $this->removeUser($playerId);

        return $this->getEnemies($history->id, $history->master_id);
    }


    public function removeUser($playerId)
    {
        $player = Player::find($playerId);
        $player->delete();
    }
}
