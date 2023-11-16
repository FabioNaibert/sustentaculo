<?php

namespace App\Http\Controllers;

use App\Http\Services\AttributesService;
use App\Http\Services\PlayerService;
use App\Http\Services\SocketiService;
use App\Http\Services\WeaponService;
use App\Models\Attribute;
use App\Models\History;
use App\Models\Player;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    private AttributesService $attributesService;
    private PlayerService $playerService;
    private SocketiService $socketiService;
    private WeaponService $weaponService;

    public function __construct(AttributesService $attributesService, PlayerService $playerService, SocketiService $socketiService, WeaponService $weaponService)
    {
        $this->attributesService = $attributesService;
        $this->playerService = $playerService;
        $this->socketiService = $socketiService;
        $this->weaponService = $weaponService;
    }


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

        return $this->playerService->getPlayers($history->id, $history->master_id);
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
            'first_access' => false,
            'active' => false,
        ]);

        $mapAttributes = $this->attributesService->mapNewAttributesPoints($allAttributes);
        $enemy->attributes()->attach($mapAttributes);

        return $this->playerService->getEnemies($historyId, $masterId);
    }


    public function removePlayer(Request $request)
    {
        $playerId = $request->input('player_id');
        $historyId = $request->input('history_id');
        $history = History::find($historyId);

        $this->weaponService->takeWeaponsFromPlayer($playerId);
        $this->removeUser($playerId);

        return $this->playerService->getPlayers($history->id, $history->master_id);
    }


    public function removeEnemy(Request $request)
    {
        $playerId = $request->input('player_id');
        $historyId = $request->input('history_id');
        $history = History::find($historyId);

        $this->removeUser($playerId);

        return $this->playerService->getEnemies($history->id, $history->master_id);
    }


    public function removeUser($playerId)
    {
        $player = Player::find($playerId);
        $player->delete();
    }


    public function updatePlayer(Request $request)
    {
        $player = $request->input('player');
        $playerOld = Player::findOrFail($player['id']);
        $userId = Auth::user()->id;

        if ($playerOld->first_access && $userId === $playerOld->user_id) {
            $mapAttributes = $this->attributesService->mapNewAttributesPoints($player['attributes']);
            $playerOld->name = $player['name'];
            $playerOld->first_access = false;
        } else if ($userId === $playerOld->user_id && $playerOld->master_id !== $userId) {
            $mapAttributes = $this->attributesService->mapAttributesTotalPoints($player['attributes']);
        } else {
            $mapAttributes = $this->attributesService->mapAttributesCurrentPoints($player['attributes']);
        }

        $playerOld->points_distribution = $player['pointsDistribution'];
        $playerOld->attributes()->sync($mapAttributes);
        $playerOld->save();

        // event socketi
        $this->socketiService->updateAll($playerOld->history_id);
    }


    public function blockPlayer(Request $request)
    {
        $playerId = $request->input('player_id');
        $active = $request->input('active');

        $player = Player::findOrFail($playerId);
        $player->active = $active;
        $player->save();

        // event soketi
        $this->socketiService->updateAll($player->history_id);
    }
}
