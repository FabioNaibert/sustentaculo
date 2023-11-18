<?php

namespace App\Http\Controllers;

use App\Events\UpdateGameEvent;
use App\Events\UpdateMasterEvent;
use App\Http\Services\ChapterService;
use App\Http\Services\HistoryService;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Contracts\Database\Eloquent\Builder;

class HistoryController extends Controller
{
    private ChapterService $chapterService;
    private HistoryService $historyService;


    public function __construct( ChapterService $chapterService, HistoryService $historyService)
    {
        $this->chapterService = $chapterService;
        $this->historyService = $historyService;
    }


    public function getHistoriesDesktop()
    {
        $user = Auth::user();

        $histories = History::with('firstChapter')->where('master_id', $user->id)->get();

        return $histories;
    }


    public function getHistoriesMobile()
    {
        $user = Auth::user();

        $histories = History::with([
            'firstChapter',
            'master:id,name',
            'players' => function (Builder $query) use ($user) {
                $query->where('players.user_id', $user->id);
            }])
            ->whereNot('master_id', $user->id)
            ->whereRelation('players', 'user_id', $user->id)
            ->get()
            ->map(fn ($history) =>
                [
                    'id' => $history->id,
                    'title' => $history->title,
                    'first_chapter' => $history->first_chapter,
                    'master' => $history->master,
                    'player' => [
                        'id' => $history->players->first()->id,
                        'name' => $history->players->first()->name,
                        'pointsDistribution' => $history->players->first()->points_distribution,
                        'firstAccess' => $history->players->first()->first_access,
                        'attributes' => $history->players->first()->attributesPoints->map(function ($attributesPoints) {
                            $attribute = $attributesPoints->attribute;
                            return [
                                'totalPoints' => $attributesPoints->total_points,
                                'currentPoints' => $attributesPoints->current_points,
                                'id' => $attribute->id,
                                'name' => $attribute->name,
                                'representationColor' => $attribute->representation_color,
                            ];
                        })
                    ],
                    'created_at' => $history->created_at,
                    'updated_at' => $history->updated_at
                ]
            );

        return $histories;
    }


    public function getHistory($id)
    {
        $allHistory = $this->historyService->getHistory($id);

        return Inertia::render('History', [
            'response' => $allHistory,
        ]);
    }

    public function getGame($id)
    {
        $allHistory = $this->historyService->getHistory($id);

        return Inertia::render('GameMaster', [
            'response' => $allHistory,
        ]);
    }


    public function getGameMobile($player_id)
    {
        $allHistory = $this->historyService->getGameMobile($player_id);

        return Inertia::render('LayoutMobile', [
            'response' => $allHistory,
        ]);
    }

    public function getGameByChapter($id, $chapter = null)
    {
        $allHistory = null;

        if ($chapter) {
            $allHistory = $this->historyService->getGame($id, $chapter);
        } else {
            $allHistory = $this->historyService->getGame($id);
        }

        return Inertia::render('GameMaster', [
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

        return $this->getHistoriesDesktop();
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
