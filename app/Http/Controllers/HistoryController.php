<?php

namespace App\Http\Controllers;

use App\Http\Services\ChapterService;
use App\Http\Services\HistoryService;
use App\Http\Services\ResourceService;
use App\Models\Attribute;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HistoryController extends Controller
{
    private PlayerController $playerController;
    private ChapterService $chapterService;
    private ResourceService $resourceService;
    private HistoryService $historyService;


    public function __construct(PlayerController $playerController, ChapterService $chapterService, ResourceService $resourceService, HistoryService $historyService)
    {
        $this->playerController = $playerController;
        $this->chapterService = $chapterService;
        $this->resourceService = $resourceService;
        $this->historyService = $historyService;
    }


    public function getHistories()
    {
        $user = Auth::user();

        $histories = History::with('firstChapter')->where('master_id', $user->id)->get();

        return Inertia::render('Dashboard', [
            'histories' => $histories
        ]);
    }

    public function getHistory($id)
    {
        $allHistory = $this->historyService->getHistory($id);

        return Inertia::render('History', [
            'response' => $allHistory,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:255'],
        ]);

        $user = Auth::user();

        $history = History::create([
            'master_id' => $user->id,
            'title' => $request->input('title')
        ]);

        $this->chapterService->addChapter(['history_id' => $history->id, 'previous_id' => null]);
    }


    public function editHistoryTitle(Request $request)
    {
        $historyId = $request->input('history_id');
        $title = $request->input('title');

        $history = History::findOrFail($historyId);
        $history->title = $title;
        $history->save();

        return $history->title;
    }
}
