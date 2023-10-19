<?php

namespace App\Http\Controllers;

use App\Http\Services\AttributesService;
use App\Models\Weapon;
use Illuminate\Http\Request;

class WeaponController extends Controller
{
    private AttributesService $attributesService;

    public function __construct(AttributesService $attributesService)
    {
        $this->attributesService = $attributesService;
    }


    public function getWeapons($historyId)
    {
        return Weapon::where('history_id', $historyId)->get();
    }


    public function addWeapon(Request $request)
    {
        $historyId = $request->input('history_id');
        $allAttributes = $request->input('all_attributes');
        $name = $request->input('name');

        $weapon = Weapon::create([
            'name' => 'ARMA_TESTE', //$name,
            'history_id' => $historyId,
        ]);

        $mapAttributes = $this->attributesService->mapAttributesPoints($allAttributes);
        $weapon->attributes()->attach($mapAttributes);

        return $this->getWeapons($historyId);
    }


    public function removeWeapon(Request $request)
    {

    }
}
