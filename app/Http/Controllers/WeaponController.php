<?php

namespace App\Http\Controllers;

use App\Http\Services\AttributesService;
use App\Http\Services\ImageService;
use App\Http\Services\ResourceService;
use App\Models\Chapter;
use App\Models\Image;
use App\Models\Weapon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WeaponController extends Controller
{
    private AttributesService $attributesService;
    private ImageService $imageService;
    private ResourceService $resourceService;


    public function __construct(AttributesService $attributesService, ImageService $imageService, ResourceService $resourceService)
    {
        $this->attributesService = $attributesService;
        $this->imageService = $imageService;
        $this->resourceService = $resourceService;
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
        $chapterId = $request->input('chapter_id');
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        $chapter = Chapter::findOrFail($chapterId);
        $imageId = $this->imageService->addImage($request->image, $chapter->history_id);

        $allAttributes = $request->input('all_attributes');
        $name = $request->input('name');

        $weapon = Weapon::create([
            'name' => $name,
            'history_id' => $chapter->history_id,
            'image_id' => $imageId
        ]);

        $mapAttributes = $this->attributesService->mapAttributesPoints($allAttributes);
        $weapon->attributes()->attach($mapAttributes);

        // return $this->getWeapons($historyId);
        return $this->resourceService->getResources($chapterId);
    }


    public function removeWeapon(Request $request)
    {
        $weaponId = $request->input('weapon_id');
        $chapterId = $request->input('chapter_id');

        $weapon = Weapon::find($weaponId);
        $this->deleteWeaponImage($weapon);
        $weapon->delete();

        // return $this->getWeapons($historyId);
        return $this->resourceService->getResources($chapterId);
    }


    public function deleteWeaponImage(Weapon $weapon)
    {
        if ($weapon->image_id)
            $this->imageService->removeImage($weapon->image_id, $weapon->history_id);
    }


    public function shareWeapon(Request $request)
    {
        $sharePlayerId = $request->input('share_player_id');
        $weaponId = $request->input('weapon_id');
        $chapterId = $request->input('chapter_id');

        $weapon = Weapon::findOrFail($weaponId);
        $weapon->player_id = $sharePlayerId;
        $weapon->save();

        return $this->resourceService->getResources($chapterId);
    }


    public function equipWeapon(Request $request)
    {
        $weaponId = $request->input('weapon_id');

        $weapon = Weapon::findOrFail($weaponId);
        Weapon::where('player_id', $weapon->player_id)->whereNot('id', $weapon->id)->update(['equiped' => false]);

        $weapon->equiped = !$weapon->equiped;
        $weapon->save();

        // event socketi
    }
}
