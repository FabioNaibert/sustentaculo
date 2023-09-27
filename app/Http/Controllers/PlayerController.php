<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlayerController extends Controller
{
    public function getPlayers($name = null)
    {
        if (!$name) return [];

        $masterId = auth()->user()->id;

        $query = User::where([
                ['id', '!=', $masterId]
            ])
            ->whereRaw("upper(name) like upper('$name%')");

        $result = $query->get();
        Log::info($query->toSql());

        return $result;
    }
}
