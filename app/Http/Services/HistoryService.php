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
    private SoundService $soundService;


    public function __construct(PlayerController $playerController, ChapterService $chapterService, ResourceService $resourceService, SoundService $soundService)
    {
        $this->playerController = $playerController;
        $this->chapterService = $chapterService;
        $this->resourceService = $resourceService;
        $this->soundService = $soundService;
    }


    public function getHistory($id, $chapter_id = null)
    {
        $history = History::findOrFail($id);
        $chapter = $this->chapterService->getChapter($id, $chapter_id);
        $players = $this->playerController->getPlayers($history->id, $history->master_id);
        $enemies = $this->playerController->getEnemies($history->id, $history->master_id);
        $resources = $this->resourceService->getResources($chapter->id);
        $sounds = $this->soundService->getSounds($chapter);

        return [
            'history' => [
                'id' => $history->id,
                'title' => $history->title,
                'masterId' => $history->master_id,
                'chapter' => $chapter,
                'players' => $players,
                'enemies' => $enemies,
                'resources' => $resources,
                'sounds' => $sounds
            ],
            'allAttributes' => Attribute::all(['id', 'name'])->map(fn ($attribute) => [
                'id' => $attribute->id,
                'name' => $attribute->name,
                'totalPoints' => null
            ])
        ];
    }


    public function getGame($id, $chapter_id = null)
    {
        $history = History::findOrFail($id);
        $chapter = $this->chapterService->getGameChapter($id, $chapter_id);
        $players = $this->playerController->getPlayers($history->id, $history->master_id);
        $enemies = $this->playerController->getEnemies($history->id, $history->master_id);
        $resources = $this->resourceService->getResources($chapter->id);
        $sounds = $this->soundService->getSounds($chapter);

        return [
            'history' => [
                'id' => $history->id,
                'title' => $history->title,
                'masterId' => $history->master_id,
                'chapter' => $chapter,
                'players' => $players,
                'enemies' => $enemies,
                'resources' => $resources,
                'sounds' => $sounds
            ],
        ];
    }
}
