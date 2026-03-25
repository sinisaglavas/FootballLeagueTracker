<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $favoriteTeams = $user->favoriteTeams()->latest()->get();
        $removedFavoriteTeams = $user->allFavoriteTeams()->onlyTrashed()->latest('deleted_at')->get();

        return view('dashboard', compact('favoriteTeams', 'removedFavoriteTeams'));
    }
}
