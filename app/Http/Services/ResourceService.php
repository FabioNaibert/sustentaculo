<?php

namespace App\Http\Services;

use App\Models\Chapter;
use App\Models\Image;
use App\Models\Weapon;

class ResourceService
{
    public function getResources($chapterId)
    {
        $chapter = Chapter::findOrFail($chapterId);
        $images = $this->getChapterImages($chapter);
        $weapons = $this->getWeapons($chapter->history_id);

        return $images->union($weapons);
    }


    public function getChapterImages(Chapter $chapter)
    {
        return $chapter->images
            ->map(fn ($image) => [
                'id' => $image->id,
                'name' => $image->name,
                'content' => $image->content,
            ]);
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
}
