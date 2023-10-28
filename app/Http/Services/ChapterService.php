<?php

namespace App\Http\Services;

use App\Models\Attribute;
use App\Models\Chapter;
use App\Models\History;

class ChapterService
{
    public function getChapter($historyId, $chapterId = null)
    {
        if (!$chapterId) {
            return History::with('lastChapter')->whereId($historyId)->get()->first()->lastChapter;
        }

        return Chapter::findOrFail($chapterId);
    }


    public function addChapter($newData)
    {
        return Chapter::create([
            'history_id' => $newData['history_id'],
            'previous_id' => $newData['previous_id'],
            // 'title' => $newData['title'],
            // 'text' => $newData['text']
        ]);
    }

    public function editChapter($newData)
    {
        $chapter = Chapter::findOrFail($newData['id']);
        $chapter->title = $newData['title'];
        $chapter->text = $newData['text'];
        $chapter->save();
    }
}
