<?php

namespace App\Http\Services;

use App\Http\Controllers\PlayerController;
use App\Models\Attribute;
use App\Models\History;
use App\Models\Player;
use Illuminate\Support\Facades\Log;

class HistoryService
{
    private PlayerController $playerController;
    private ChapterService $chapterService;
    private ResourceService $resourceService;
    private SoundService $soundService;
    private PlayerService $playerService;


    public function __construct(PlayerController $playerController, ChapterService $chapterService, ResourceService $resourceService, SoundService $soundService, PlayerService $playerService)
    {
        $this->playerController = $playerController;
        $this->playerService = $playerService;
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


    public function getHistoryMobile($player_id)
    {
        $player = Player::findOrFail($player_id);
        $history = History::findOrFail($player->history_id);

        $playerMap = $this->playerService->getPlayer($player_id);
        $team = $this->playerService->getTeam($history->id, $history->master_id, $player_id);
        $resoucers = $this->resourceService->getImagesPlayer($player);
        $backpack = $this->resourceService->getWeaponsPlayer($player_id);

        return [
            'history' => $history,
            'player' => $playerMap,
            'team' => $team,
            'resoucers' => $resoucers,
            'backpack' => $backpack
        ];
    }
}
