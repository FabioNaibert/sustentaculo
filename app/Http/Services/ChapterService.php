<?php

namespace App\Http\Services;

use App\Models\Attribute;
use App\Models\Chapter;

class ChapterService
{
    public function getChapters($historyId)
    {
        return Chapter::where('history_id', $historyId)
            ->orderBy('id')
            ->get()
            ->mapWithKeys (function ($chapter) {
                return [
                    $chapter->id => [
                        'id' => $chapter->id,
                        'title' => $chapter->title,
                        'text' => $chapter->text,
                        'previous_id' => $chapter->previous_id,
                    ]
                ];
            });
    }
}
