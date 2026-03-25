<?php

namespace App\Http\Controllers;

use App\Services\FootballDataService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;

class CompetitionController extends Controller
{
    /**
     * @throws ConnectionException
     */
    public function index(FootballDataService $footballDataService): View
    {
        $data = $footballDataService->getCompetitions();

        $competitions = $data['competitions'] ?? [];

        return view('competitions.index', compact('competitions'));
    }

    /**
     * @throws ConnectionException
     */
    public function standings(FootballDataService $footballDataService, $code): View
    {
        $data = $footballDataService->getCompetitionStandings($code);

        $standings = $data['standings'][0]['table'] ?? [];
        $competition = $data['competition'] ?? [];
        $area = $data['area'] ?? [];

        $favoriteIds = auth()->check()
            ? auth()->user()->allFavoriteTeams()->pluck('favorite_team_id')->toArray()
            : []; // if team is favorite, add id to array - and in blade have not 'favorite' button

        return view('competitions.standings', compact('standings', 'competition', 'area', 'favoriteIds'));
    }

    /**
     * @throws ConnectionException
     */
    public function matches(FootballDataService $footballDataService, $code): View
    {
        $data = $footballDataService->getMatches($code);

        $matches = $data['matches'] ?? [];
        $competition = $data['competition'] ?? null;

        return view('competitions.matches', compact('matches', 'competition'));
    }

    /**
     * @throws ConnectionException
     */
    public function show(FootballDataService $footballDataService, $id): View
    {
        $team = $footballDataService->getTeam($id);

        $coach = $team['coach'] ?? [];
        $squad = $team['squad'] ?? [];

        return view('competitions.show', compact('team', 'coach', 'squad'));
    }
}
