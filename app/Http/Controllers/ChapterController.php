<?php

namespace App\Http\Controllers;

use App\Http\Services\ChapterService;
use App\Models\Chapter;
use App\Models\History;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    private ChapterService $chapterService;


    public function __construct(ChapterService $chapterService)
    {
        $this->chapterService = $chapterService;
    }


    public function addChapter(Request $request)
    {
        $historyId = $request->input('history_id');
        $previousChapterId = $request->input('previous_chapter_id');
        $title = $request->input('title');
        $text = $request->input('text');

        History::findOrFail($historyId);

        $chapter = Chapter::create([
            'history_id' => $request->input('historyId'),
            'previous_id' => $previousChapterId,
            'title' => $title,
            'text' => $text
        ]);

        return $this->chapterService->getChapters($historyId);
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

        return $this->chapterService->getChapters($chapter->history_id);
    }


    public function removeChapter(Request $request)
    {
        $chapterId = $request->input('chapter_id');
        $currentChapter = Chapter::findOrFail($chapterId);

        $next = Chapter::where('previous_id', $currentChapter->id)->first();
        $next->previous_id = $currentChapter->previous_id;
        $next->save();

        $currentChapter->delete();

        return $this->chapterService->getChapters($next->history_id);
    }
}
