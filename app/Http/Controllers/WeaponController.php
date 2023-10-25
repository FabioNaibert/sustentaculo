<?php

namespace App\Http\Controllers;

use App\Http\Services\AttributesService;
use App\Http\Services\ImageService;
use App\Models\Image;
use App\Models\Weapon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WeaponController extends Controller
{
    private AttributesService $attributesService;
    private ImageService $imageService;

    public function __construct(AttributesService $attributesService, ImageService $imageService)
    {
        $this->attributesService = $attributesService;
        $this->imageService = $imageService;
    }


    public function getWeapons($historyId)
    {
        return Weapon::where('history_id', $historyId)
            ->with('image')
            ->get()
            ->map(fn ($weapon) => [
                'id' => $weapon->id,
                'name' => $weapon->name,
                'image' => [
                    'id' => $weapon->image->id,
                    'name' => $weapon->image->name,
                    'content' => $weapon->image->content,
                ],
                'attributes' => $weapon->attributesPoints->map(function ($attributesPoints) {
                    $attribute = $attributesPoints->attribute;
                    return [
                        'totalPoints' => $attributesPoints->total_points,
                        'id' => $attribute->id,
                        'name' => $attribute->name
                    ];
                })
            ]);
    }


    public function addWeapon(Request $request)
    {
        $historyId = $request->input('history_id');
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        $imageId = $this->imageService->addImage($request->image, $historyId);


        $allAttributes = $request->input('all_attributes');
        $name = $request->input('name');

        $weapon = Weapon::create([
            'name' => $name,
            'history_id' => $historyId,
            'image_id' => $imageId
        ]);

        $mapAttributes = $this->attributesService->mapAttributesPoints($allAttributes);
        $weapon->attributes()->attach($mapAttributes);

        return $this->getWeapons($historyId);
    }


    public function removeWeapon(Request $request)
    {
        $weaponId = $request->input('weapon_id');

        $weapon = Weapon::find($weaponId);
        $this->deleteWeaponImage($weapon);

        $historyId = $weapon->history_id;
        $weapon->delete();
        return $this->getWeapons($historyId);
    }


    public function deleteWeaponImage(Weapon $weapon)
    {
        if ($weapon->image_id)
            $this->imageService->removeImage($weapon->image_id, $weapon->history_id);
    }
}
