<?php

namespace App\Http\Services;

use App\Models\Player;
use Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PlayerService
{
    const VIDA = 1;

    private AttributesService $attributesService;


    public function __construct(AttributesService $attributesService)
    {
        $this->attributesService = $attributesService;
    }


    public function getPlayer($playerId)
    {
        $players = Player::whereId($playerId)->get();

        return $this->mapPlayers($players)->first();
    }


    public function getPlayers($historyId, $masterId)
    {
        $players = Player::where([
                ['history_id', $historyId],
                ['user_id', '!=', $masterId]
            ])
            ->get();

        return $this->mapPlayers($players);
    }

    public function getEnemies($historyId, $masterId)
    {
        $enemies = Player::where([
                ['history_id', $historyId],
                ['user_id', '=', $masterId]
            ])
            ->get();

        return $this->mapPlayers($enemies);
    }


    public function getTeam($historyId, $masterId, $playerId)
    {
        $players = Player::where([
            ['history_id', $historyId],
            ['user_id', '!=', $masterId],
            ['id', '!=', $playerId],
        ])->get();

        return $this->mapPlayers($players);

    }

    public function mapPlayers(Collection $players)
    {
        return $players->map(function ($player) {
            $weaponAttributes = $this->attributesService->weaponAttributes($player);

            return [
                'id' => $player->id,
                'name' => $player->name,
                'pointsDistribution' => $player->points_distribution,
                'userId' => $player->user_id,
                'active' => $player->active,
                'attributes' => $this->mapAttributes($player->attributesPoints, $weaponAttributes)
            ];
        });
    }


    public function getOpponents($players)
    {
        return $players->filter(function ($player) {
            return $player['active'] && $player['attributes']->firstWhere('id', self::VIDA)['currentPoints'] > 0;
        });
    }


    public function mapAttributes(Collection $attributesPoints, $weaponAttributes)
    {
        return $attributesPoints->map(function ($attributesPoints) use ($weaponAttributes) {
                $attribute = $attributesPoints->attribute;
                $totalPoints = $attributesPoints->total_points + $weaponAttributes[$attribute->id]['totalPoints'];
                $currentPonts = $attributesPoints->current_points;

                if ($currentPonts > $totalPoints) {
                    $currentPonts = $totalPoints;
                }

                return [
                    'totalPoints' => $totalPoints,
                    'currentPoints' => $currentPonts,
                    'id' => $attribute->id,
                    'name' => $attribute->name,
                    'representationColor' => $attribute->representation_color,
                ];
            })
            ->sortBy('id')
            ->values();
    }
}
