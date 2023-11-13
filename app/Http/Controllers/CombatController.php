<?php

namespace App\Http\Controllers;

use App\Http\Services\AttributesService;
use App\Http\Services\PlayerService;
use App\Models\Attribute;
use App\Models\Player;
use Illuminate\Http\Request;

class CombatController extends Controller
{
    private AttributesService $attributesService;
    private PlayerService $playerService;


    public function __construct(AttributesService $attributesService, PlayerService $playerService)
    {
        $this->attributesService = $attributesService;
        $this->playerService = $playerService;
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

        Player::whereIn('id', $opponentsIds)
            ->get()
            ->each(function ($player) use ($hit) {
                $weaponAttributes = $this->attributesService->weaponAttributes($player);
                $attributes = $this->playerService->mapAttributes($player->attributesCalc, $weaponAttributes);

                $calcHit = $this->attributesService->calcHit($attributes, $hit);
                $player->attributes()->syncWithoutDetaching($calcHit);
            });

        // event socketi
    }
}
