<?php

namespace App\Http\Services;

use App\Models\Attribute;
use App\Models\Chapter;
use App\Models\History;
use Illuminate\Support\Facades\Log;

class ChapterService
{
    private ImageService $imageService;


    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }


    public function getChapter($historyId, $chapterId = null)
    {
        if (!$chapterId) {
            return History::with('lastChapter')->whereId($historyId)->get()->first()->lastChapter->setAppends(['has_next', 'has_multi_routes', 'possible_routes']);
        }

        return Chapter::findOrFail($chapterId)->setAppends(['has_next', 'has_multi_routes', 'possible_routes']);
    }


    public function getGameChapter($historyId, $chapterId = null)
    {
        if (!$chapterId) {
            return History::with('firstChapter')->whereId($historyId)->get()->first()->firstChapter->setAppends(['has_next', 'has_multi_routes', 'possible_routes']);
        }

        return Chapter::findOrFail($chapterId)->setAppends(['has_next', 'has_multi_routes', 'possible_routes']);
    }


    public function getNextChapterId($currentId, $nextId)
    {
        if ($nextId) {
            $chapter = Chapter::findOrFail($nextId);
        } else {
            $chapter = Chapter::wherePreviousId($currentId)->first();
        }

        if ($chapter) {
            return $chapter->id;
        }
    }


    public function addChapter($newData)
    {
        return Chapter::create([
            'history_id' => $newData['history_id'],
            'previous_id' => $newData['previous_id'],
        ]);
    }

    public function editChapter($newData)
    {
        $chapter = Chapter::findOrFail($newData['id']);
        $chapter->title = $newData['title'];
        $chapter->text = $newData['text'];
        $chapter->save();

        return $chapter;
    }

    public function removeChapter($chapterId)
    {
        $chapter = Chapter::findOrFail($chapterId);
        $historyId = $chapter->history_id;
        $previousId = $chapter->previous_id;

        Chapter::where('previous_id', $chapter->id)->update(['previous_id' => $chapter->previous_id]);
        $this->imageService->removeImages($chapter);

        $chapter->delete();

        return [$historyId, $previousId];
    }
}
