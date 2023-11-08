<?php

namespace App\Http\Services;

use App\Models\Player;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class PlayerService
{
    public function getPlayer($playerId)
    {
        $players = Player::whereId($playerId)->get();

        return $this->mapPlayers($players)->first();
    }


    public function getTeam($historyId, $masterId, $playerId)
    {
        $players = Player::where([
            ['history_id', $historyId],
            ['user_id', '!=', $masterId],
            ['user_id', '!=', $playerId],
        ])->get();

        return $this->mapPlayers($players);

    }

    public function mapPlayers(Collection $players)
    {
        return $players->map(fn ($player) => [
            'id' => $player->id,
            'name' => $player->name,
            'attributes' => $this->mapAttributes($player->attributesPoints)
        ]);
    }

    private function mapAttributes(Collection $attributesPoints)
    {
        return $attributesPoints->map(function ($attributesPoints) {
                $attribute = $attributesPoints->attribute;
                return [
                    'totalPoints' => $attributesPoints->total_points,
                    'currentPoints' => $attributesPoints->current_points,
                    'id' => $attribute->id,
                    'name' => $attribute->name,
                    'representationColor' => $attribute->representation_color,
                ];
            })
            ->sortBy('id')
            ->values();
    }
}
