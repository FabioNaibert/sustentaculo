<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateGameEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $historyId;

    public function __construct($historyId)
    {
        $this->historyId = $historyId;
    }


    public function broadcastWith()
    {
        return ['t' => 'testeeee'];
    }


    public function broadcastOn()
    {
        return [
            new Channel('update-game-master.'.$this->historyId),
            new Channel('update-game-player.'.$this->historyId),
        ];
    }
}
