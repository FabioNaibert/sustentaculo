<?php

namespace App\Http\Services;

use App\Models\Weapon;

class WeaponService
{
    public function takeWeaponsFromPlayer($playerId)
    {
        Weapon::where('player_id', $playerId)->update(['player_id' => null]);
    }
}
