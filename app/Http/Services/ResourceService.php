<?php

namespace App\Http\Services;

use App\Models\Chapter;
use App\Models\Player;
use App\Models\Weapon;
use Illuminate\Database\Eloquent\Collection;

class ResourceService
{
    public function getResources($chapterId)
    {
        $chapter = Chapter::findOrFail($chapterId);
        $images = $this->getChapterImages($chapter);
        $weapons = $this->getWeapons($chapter->history_id);
        $resources = [...$images, ...$weapons];

        return $resources;
    }


    public function getChapterImages(Chapter $chapter)
    {
        return $chapter->images
            ->map(fn ($image) => [
                'id' => $image->id,
                'name' => $image->name,
                'content' => $image->content,
                'share_players_ids' => $image->share_players_ids,
            ]);
    }


    public function getImagesPlayer(?Player $player)
    {
        return $player->images
            ->map(fn ($image) => [
                'id' => $image->id,
                'name' => $image->name,
                'content' => $image->content,
                'updatedAt' => $image->updated_at,
            ]);
    }


    public function getWeapons($historyId)
    {
        $weapons = Weapon::where('history_id', $historyId)
            ->with('image')
            ->get();

        return $this->mapWeapons($weapons);
    }


    public function getWeaponsPlayer($playerId)
    {
        $weapons = Weapon::where('player_id', $playerId)
            ->with('image')
            ->get();

        return $this->mapWeapons($weapons);
    }


    private function mapWeapons(Collection $weapons)
    {
        return $weapons->map(fn ($weapon) => [
            'id' => $weapon->id,
            'name' => $weapon->name,
            'playerId' => $weapon->player_id,
            'updatedAt' => $weapon->updated_at,
            'equiped' => $weapon->equiped,
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
}
