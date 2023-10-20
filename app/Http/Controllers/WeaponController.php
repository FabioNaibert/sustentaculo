<?php

namespace App\Http\Controllers;

use App\Http\Services\AttributesService;
use App\Models\Weapon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ]);
        $imageName = time().'.'.$request->image->extension();

        // Public Folder
        $request->image->move(public_path(), $imageName);


        $historyId = $request->input('history_id');
        $allAttributes = $request->input('all_attributes');
        $name = $request->input('name');
        $image = $request->input('image');
        Log::info($image);

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
