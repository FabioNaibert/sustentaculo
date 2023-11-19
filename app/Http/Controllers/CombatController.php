<?php

namespace App\Http\Controllers;

use App\Http\Services\AttributesService;
use App\Http\Services\PlayerService;
use App\Http\Services\SocketiService;
use App\Models\Attribute;
use App\Models\Player;
use Illuminate\Http\Request;

class CombatController extends Controller
{
    public const VIDA = 1;
    public const MANA = 2;
    public const ATAQUE = 3;
    public const DEFESA = 4;

    private AttributesService $attributesService;
    private PlayerService $playerService;
    private SocketiService $socketiService;


    public function __construct(AttributesService $attributesService, PlayerService $playerService, SocketiService $socketiService)
    {
        $this->attributesService = $attributesService;
        $this->playerService = $playerService;
        $this->socketiService = $socketiService;
    }


    public function attack(Request $request)
    {
        $opponentsIds = $request->input('opponents_ids');
        $hit = $request->input('hit');
        $magicAttack = $request->input('magic_attack');
        $playerId = $request->input('player_id');

        if ($magicAttack) {
            $player = Player::findOrFail($playerId);
            $weaponAttributes = $this->attributesService->weaponAttributes($player);
            $attributes = $this->playerService->mapAttributes($player->attributesCalc, $weaponAttributes);

            $calcMana = $this->attributesService->spentMana($attributes);
            $player->attributes()->syncWithoutDetaching($calcMana);
        }

        $opponents = Player::whereIn('id', $opponentsIds)
            ->get()
            ->each(function ($player) use ($hit) {
                $weaponAttributes = $this->attributesService->weaponAttributes($player);
                $attributes = $this->playerService->mapAttributes($player->attributesCalc, $weaponAttributes);

                $calcHit = $this->attributesService->calcHit($attributes, $hit);
                $player->attributes()->syncWithoutDetaching($calcHit);

                if ($calcHit[self::VIDA]['current_points'] === 0) {
                    $player->active = false;
                    $player->save();
                }
            });

        // event socketi
        $this->socketiService->updateAll($opponents->first()->history_id);
    }
}
