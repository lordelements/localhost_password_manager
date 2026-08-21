<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $totalEntries = $user->vaultEntries()->count();
        $favoriteCount = $user->vaultEntries()->where('favorite', true)->count();

        $recentEntries = $user->vaultEntries()
            ->with(['folder', 'category'])
            ->latest()
            ->take(5)
            ->get();

        $recentActivity = $user->activityLogs()
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalEntries',
            'favoriteCount',
            'recentEntries',
            'recentActivity',
        ));
    }
}