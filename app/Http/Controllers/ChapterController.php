<?php

namespace App\Http\Controllers;

use App\Http\Services\ChapterService;
use App\Http\Services\HistoryService;
use App\Models\Chapter;
use App\Models\History;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    private ChapterService $chapterService;
    private HistoryService $historyService;


    public function __construct(ChapterService $chapterService, HistoryService $historyService)
    {
        $this->chapterService = $chapterService;
        $this->historyService = $historyService;
    }


    public function addChapter(Request $request)
    {
        $currentChapter = $request->input('current');
        $newData = $request->input('new_data');

        $this->chapterService->editChapter($currentChapter);
        $chapter = $this->chapterService->addChapter($newData);

        return $this->historyService->getHistory($chapter->history_id, $chapter->id);
    }


    public function editChapter(Request $request)
    {
        $chapterId = $request->input('chapter_id');
        $previousChapterId = $request->input('previous_chapter_id');
        $title = $request->input('title');
        $text = $request->input('text');

        $chapter = Chapter::findOrFail($chapterId);
        $chapter->title = $title;
        $chapter->text = $text;
        $chapter->previous_id = $previousChapterId;
        $chapter->save();

        return $this->chapterService->getChapter($chapter->history_id);
    }


    public function removeChapter(Request $request)
    {
        $chapterId = $request->input('chapter_id');
        $currentChapter = Chapter::findOrFail($chapterId);

        $next = Chapter::where('previous_id', $currentChapter->id)->first();
        $next->previous_id = $currentChapter->previous_id;
        $next->save();

        $currentChapter->delete();

        return $this->chapterService->getChapter($next->history_id);
    }
}
