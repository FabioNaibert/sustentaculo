<?php

namespace App\Http\Services;

use App\Models\Attribute;
use App\Models\Chapter;
use Illuminate\Support\Facades\Log;

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
