<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class ChapterController extends Controller
{
    public function store(Request $request): Response
    {
        $history = History::find($request->input('historyId'));

        if ($history) {
            $chapter = $history->last_chapter;
        } else {
            $chapter = Chapter::create([
                'history_id' => $request->input('historyId')
            ]);
        }

        return Inertia::render('History', [
            'chapter' => $chapter,
        ]);
    }
}
