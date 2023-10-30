<?php

namespace App\Http\Services;

use App\Models\Attribute;
use App\Models\Chapter;

class SoundService
{
    public function getSounds(Chapter $chapter)
    {
        return $chapter->sounds
            ->map(fn ($image) => [
                'id' => $image->id,
                'name' => $image->name,
                'content' => $image->content,
            ]);
    }
}
