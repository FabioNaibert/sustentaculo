<?php

namespace App\Http\Controllers;

use App\Http\Services\ChapterService;
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


    public function __construct(PlayerController $playerController, ChapterService $chapterService, ResourceService $resourceService)
    {
        $this->playerController = $playerController;
        $this->chapterService = $chapterService;
        $this->resourceService = $resourceService;
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
        $history = History::find($id);
        $chapters = $this->chapterService->getChapters($id);
        $players = $this->playerController->getPlayers($history->id, $history->master_id);
        $enemies = $this->playerController->getEnemies($history->id, $history->master_id);
        $resources = $this->resourceService->getResources($chapters->first()['id']);

        $allHistory = [
            'history' => [
                'id' => $history->id,
                'title' => $history->title,
                'masterId' => $history->master_id,
                'chapters' => $chapters,
                'players' => $players,
                'enemies' => $enemies,
                'resources' => $resources
            ],
            'allAttributes' => Attribute::all(['id', 'name'])->map(fn ($attribute) => [
                'id' => $attribute->id,
                'name' => $attribute->name,
                'totalPoints' => null
            ])
        ];

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

        History::create([
            'master_id' => $user->id,
            'title' => $request->input('title')
        ]);
    }
}
