@extends('layout')

@section('content')

    <x-app-layout>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="bg-white shadow-sm sm:rounded-lg p-6">

                    <h1 class="text-2xl font-bold mb-6">
                        Standings - {{ $competition['name'] ?? '' }}
                    </h1>

                    @if(empty($standings))
                        <p>No standings available.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-200 text-sm">
                                <thead class="bg-gray-100">
                                <tr class="text-center">
                                    <th class="px-2 py-2 border">#</th>
                                    <th class="px-2 py-2 border text-left">Team</th>
                                    <th class="px-2 py-2 border">MP</th>
                                    <th class="px-2 py-2 border">W</th>
                                    <th class="px-2 py-2 border">D</th>
                                    <th class="px-2 py-2 border">L</th>
                                    <th class="px-2 py-2 border">GF</th>
                                    <th class="px-2 py-2 border">GA</th>
                                    <th class="px-2 py-2 border">GD</th>
                                    <th class="px-2 py-2 border font-bold">PTS</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($standings as $row)
                                    <tr class="text-center @if($row['position'] <= 4) bg-green-100 @endif">
                                        <td class="border px-2 py-1">
                                            {{ $row['position'] }}
                                        </td>

                                        <td class="border px-2 py-1 text-left">
                                            <div class="flex items-center justify-between gap-2">

                                                @if($row['team']['id'] === null)
                                                    <p>-</p>
                                                @else
                                                    <a href="{{ route('competitions.show', $row['team']['id']) }}" class="text-blue-600 hover:underline">{{ $row['team']['name'] }}
                                                        @if(isset($row['team']['crest']))
                                                            <img src="{{ $row['team']['crest'] }}"
                                                                 alt="logo"
                                                                 class="w-6 h-6">
                                                        @endif
                                                    </a>

                                                    <!-- FAVORITE BUTTON -->
                                                    @auth
                                                        @if(in_array($row['team']['id'], $favoriteIds))
                                                            <span class="text-green-600 text-xs font-bold">✔ Favorited</span>
                                                        @else
                                                            <!-- BUTTON -->
                                                            <form method="POST" action="{{ route('favorite-teams.store') }}">
                                                                @csrf

                                                                <input type="hidden" name="favorite_team_id" value="{{ $row['team']['id'] }}">
                                                                <input type="hidden" name="favorite_team_name" value="{{ $row['team']['name'] }}">
                                                                <input type="hidden" name="favorite_team_crest" value="{{ $row['team']['crest'] ?? '' }}">
                                                                <input type="hidden" name="favorite_team_country" value="{{ $area['name'] ?? '' }}">

                                                                <button type="submit"
                                                                        class="text-xs px-2 py-1 bg-yellow-200 hover:bg-yellow-400 rounded font-semibold">
                                                                    ⭐ Favorite
                                                                </button>
                                                            </form>
                                                        @endif

                                                    @endauth
                                                @endif
                                            </div>
                                        </td>

                                        <td class="border px-2 py-1">
                                            {{ $row['playedGames'] }}
                                        </td>

                                        <td class="border px-2 py-1">
                                            {{ $row['won'] }}
                                        </td>

                                        <td class="border px-2 py-1">
                                            {{ $row['draw'] }}
                                        </td>

                                        <td class="border px-2 py-1">
                                            {{ $row['lost'] }}
                                        </td>

                                        <td class="border px-2 py-1">
                                            {{ $row['goalsFor'] }}
                                        </td>

                                        <td class="border px-2 py-1">
                                            {{ $row['goalsAgainst'] }}
                                        </td>

                                        <td class="border px-2 py-1">
                                            {{ $row['goalDifference'] }}
                                        </td>

                                        <td class="border px-2 py-1 font-bold">
                                            {{ $row['points'] }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    @endif

                </div>
            </div>
        </div>
    </x-app-layout>

@endsection

