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
        $currentChapter = $request->input('current');
        $this->chapterService->editChapter($currentChapter);
    }


    public function removeChapter(Request $request)
    {
        $chapterId = $request->input('id');

        [$historyId, $previousId] = $this->chapterService->removeChapter($chapterId);

        return $this->historyService->getHistory($historyId, $previousId);
    }


    public function previousChapter(Request $request)
    {
        $currentChapter = $request->input('current');
        $chapter = $this->chapterService->editChapter($currentChapter);

        return $this->historyService->getHistory($chapter->history_id, $chapter->previous_id);
    }


    public function nextChapter(Request $request)
    {
        $currentChapter = $request->input('current');
        $nextId = $request->input('next_id');

        $chapter = $this->chapterService->editChapter($currentChapter);
        $nextId = $this->chapterService->getNextChapterId($currentChapter, $nextId);

        return $this->historyService->getHistory($chapter->history_id, $nextId);
    }
}
