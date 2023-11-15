<?php

namespace App\Events;

use App\Http\Services\HistoryService;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdatePlayerEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $playerId;
    private $historyService;

    public function __construct($playerId)
    {
        $this->playerId = $playerId;
    }


    public function broadcastWith()
    {
        $this->historyService = app()->make(HistoryService::class);
        return ['response' => $this->historyService->getGameMobile($this->playerId)];
    }


    public function broadcastOn()
    {
        return new Channel('update-game-player.'.$this->playerId);
    }
}
