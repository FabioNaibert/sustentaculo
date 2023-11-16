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
use Illuminate\Support\Facades\Log;

class UpdateMasterEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $historyId;
    private $historyService;

    public function __construct($historyId)
    {
        $this->historyId = $historyId;
    }


    public function broadcastWith()
    {
        $this->historyService = app()->make(HistoryService::class);
        return ['response' => $this->historyService->getGame($this->historyId)];
    }


    public function broadcastOn()
    {
        return new Channel('update-game-master.'.$this->historyId);
    }
}
