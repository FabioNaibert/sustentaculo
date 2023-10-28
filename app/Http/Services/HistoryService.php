<?php

namespace App\Http\Services;

use App\Http\Controllers\PlayerController;
use App\Models\Attribute;
use App\Models\History;

class HistoryService
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


    public function getHistory($id, $chapter_id = null)
    {
        $history = History::findOrFail($id);
        $chapter = $this->chapterService->getChapter($id, $chapter_id);
        $players = $this->playerController->getPlayers($history->id, $history->master_id);
        $enemies = $this->playerController->getEnemies($history->id, $history->master_id);
        $resources = $this->resourceService->getResources($chapter->id);

        return [
            'history' => [
                'id' => $history->id,
                'title' => $history->title,
                'masterId' => $history->master_id,
                'chapter' => $chapter,
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
    }
}
