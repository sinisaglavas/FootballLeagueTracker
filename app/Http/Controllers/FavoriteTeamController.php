<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewFavoriteTeamRequest;
use App\Models\FavoriteTeam;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FavoriteTeamController extends Controller
{
    public function store(NewFavoriteTeamRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        $favoriteTeam = FavoriteTeam::create($validated);

        return redirect()->route('dashboard')->with('success', 'Team added to favorites.');
    }

    public function destroy(FavoriteTeam $favoriteTeam): RedirectResponse
    {
        abort_unless($favoriteTeam->user_id === Auth::id(), 403);

        $favoriteTeam->delete();

        return redirect()->route('dashboard')->with('success', 'Team removed from favorites.');
    }

    public function restore(int $id): RedirectResponse
    {
        $favoriteTeam = FavoriteTeam::withTrashed()->where('user_id', Auth::id())->findOrFail($id);

        $favoriteTeam->restore();

        return redirect()->route('dashboard')->with('success', 'Team restored to favorites.');
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $favoriteTeam = FavoriteTeam::withTrashed()->where('user_id', Auth::id())->findOrFail($id);

        $favoriteTeam->forceDelete();

        return redirect()->route('dashboard')->with('success', 'Team permanently deleted.');
    }

}
