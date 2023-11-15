<?php

use App\Models\History;
use App\Models\Player;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('update-game-master.{idHistory}', function (User $user, $idHistory) {
    return History::findOrFail($idHistory)->master_id === $user->id;
});

Broadcast::channel('update-game-player.{playerId}', function (User $user, $playerId) {
    return Player::findOrFail($playerId)->user_id === $user->id;
});
