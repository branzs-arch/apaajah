<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $activities = \App\Models\ActivityLog::with('user')
            ->latest()
            ->paginate(50);

        return view('history.index', compact('activities'));
    }
}
