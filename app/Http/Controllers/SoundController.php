<?php

namespace App\Http\Controllers;

use App\Http\Services\SoundService;
use App\Models\Chapter;
use App\Models\Sound;
use Illuminate\Http\Request;

class SoundController extends Controller
{
    private SoundService $soundService;

    public function __construct(SoundService $soundService)
    {
        $this->soundService = $soundService;
    }


    public function getSounds(Request $request)
    {
        $name = $request->input('name');
        $chapter_id = $request->input('chapter_id');

        if (!$name) return [];

        $existingSounds = Sound::whereRelation('chapters', 'chapter_id', $chapter_id)->get()->pluck('id');

        $query = Sound::whereRaw("upper(name) like upper('%$name%')");

        if ($existingSounds->isNotEmpty()) {
            $query->whereNotIn('id', $existingSounds);
        }

        return $query->get();
    }


    public function addSound(Request $request)
    {
        $chapterId = $request->input('chapter_id');
        $soundId = $request->input('sound_id');

        Sound::findOrFail($soundId);
        $chapter = Chapter::findOrFail($chapterId);
        $chapter->sounds()->attach($soundId);

        return $this->soundService->getSounds($chapter);
    }

    public function removeSound(Request $request)
    {
        $chapterId = $request->input('chapter_id');
        $soundId = $request->input('sound_id');

        $chapter = Chapter::findOrFail($chapterId);
        $chapter->sounds()->detach($soundId);

        return $this->soundService->getSounds($chapter);
    }
}
