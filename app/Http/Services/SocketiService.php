<?php

namespace App\Http\Services;

use App\Events\UpdateMasterEvent;
use App\Events\UpdatePlayerEvent;
use App\Models\Chapter;
use App\Models\History;
use App\Models\Player;

class SocketiService
{
    public function updateAll($historyId)
    {
        $history = History::findOrFail($historyId);
        UpdateMasterEvent::dispatch($history->id);

        $playersIds = Player::where([
                ['history_id', $history->id],
                ['user_id', '!=', $history->master_id]
            ])
            ->get()
            ->pluck('id');

        $playersIds->each(function ($playerId) {
            UpdatePlayerEvent::dispatch($playerId);
        });
    }
}
