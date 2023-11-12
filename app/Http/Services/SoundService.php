<?php

namespace App\Http\Services;

use App\Models\Chapter;

class SoundService
{
    public function getSounds(Chapter $chapter)
    {
        return $chapter->sounds
            ->map(fn ($sound) => [
                'id' => $sound->id,
                'name' => $sound->name,
                'content' => $sound->content,
            ]);
    }
}
