<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">
                    Matches - {{ $competition['name'] ?? '' }}
                </h1>

                @if(empty($matches))
                    <p>No matches found.</p>
                @else
                    <div class="overflow-x-auto">

                        @php
                            $matchdays = collect($matches)->pluck('matchday')->filter()->unique()->sort();
                        @endphp

                        <div class="mb-6 flex gap-4 items-end">

                            <!-- STATUS FILTER -->
                            <div>
                                <label for="matchFilter" class="block mb-2 text-sm font-medium text-gray-700">
                                    Filter matches
                                </label>

                                <select id="matchFilter" class="border border-gray-300 rounded px-3 py-2">
                                    <option value="all">All matches</option>
                                    <option value="played">Only played</option>
                                    <option value="upcoming">Only upcoming</option>
                                </select>
                            </div>

                            <!-- MATCHDAY FILTER -->
                            <div>
                                <label for="matchdayFilter" class="block mb-2 text-sm font-medium text-gray-700">
                                    Filter by match day
                                </label>

                                <select id="matchdayFilter" class="border border-gray-300 rounded px-3 py-2">
                                    <option value="all">All match days</option>

                                    @foreach($matchdays as $matchday)
                                        <option value="{{ $matchday }}">Match day {{ $matchday }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <table class="min-w-full border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 py-2 border">Date</th>
                                <th class="px-3 py-2 border">Home Team</th>
                                <th class="px-3 py-2 border">Away Team</th>
                                <th class="px-3 py-2 border">Half Time</th>
                                <th class="px-3 py-2 border">Score</th>
                                <th class="px-3 py-2 border">Status</th>
                                <th class="px-3 py-2 border">Matchday</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($matches as $match)
                                @php
                                    $status = $match['status'] ?? '';
                                @endphp

                                <tr class="matchRow" data-status="{{ $status }}" data-matchday="{{ $match['matchday'] ?? '' }}">
                                    <td class="px-3 py-2 border">
                                        {{ \Carbon\Carbon::parse($match['utcDate'])->setTimezone('Europe/Belgrade')->format('d.m.Y H:i') }}
                                    </td>
                                    <td class="px-3 py-2 border">
                                        @if(!empty($match['homeTeam']['name']))
                                            <a href="{{ route('competitions.show', $match['homeTeam']['id']) }}" class="text-blue-600 hover:underline">
                                                {{ $match['homeTeam']['name'] }}
                                            </a>
                                        @else
                                            -
                                        @endif

                                    </td>
                                    <td class="px-3 py-2 border">
                                        @if(!empty($match['awayTeam']['name']))
                                            <a href="{{ route('competitions.show', $match['awayTeam']['id']) }}" class="text-blue-600 hover:underline">
                                                {{ $match['awayTeam']['name'] }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 border">
                                        {{ $match['score']['halfTime']['home'] ?? '-' }} :
                                        {{ $match['score']['halfTime']['away'] ?? '-' }}
                                    </td>
                                    <td class="px-3 py-2 border">
                                        {{ $match['score']['fullTime']['home'] ?? '-' }} :
                                        {{ $match['score']['fullTime']['away'] ?? '-' }}
                                    </td>
                                    <td class="px-3 py-2 border">
                                        @php
                                        $classes = match ($status) {
                                        'LIVE', 'IN_PLAY' => 'bg-green-100 text-green-800',
                                        'PAUSED' => 'bg-yellow-100 text-yellow-800',
                                        'FINISHED' => 'bg-gray-300 text-gray-800',
                                        'SCHEDULED', 'TIMED' => 'bg-blue-100 text-blue-800',
                                        'POSTPONED', 'CANCELED' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-700',
                                        };

                                        $label = match($status) {
                                            'LIVE', 'IN_PLAY' => 'LIVE',
                                             'PAUSED' => 'PAUSED',
                                             'FINISHED' => 'FINISHED',
                                             'SCHEDULED', 'TIMED' => 'SCHEDULED',
                                             'POSTPONED' => 'POSTPONED',
                                             'CANCELED' => 'CANCELED',
                                             default => $status
                                        };
                                        @endphp

                                        <span class="px-2 py-1 text-xs font-semibold rounded {{ $classes }}">
                                            {{ $label }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 border">
                                        {{ $match['matchday'] ?? '-' }}
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusFilter = document.getElementById('matchFilter');
            const matchdayFilter = document.getElementById('matchdayFilter');
            const rows = document.querySelectorAll('.matchRow');

            function filterMatches() {
                const statusValue = statusFilter.value;
                const matchdayValue = matchdayFilter.value;

                rows.forEach(row => {
                    const status = row.dataset.status;
                    const matchday = row.dataset.matchday;

                    const playedStatuses = ['FINISHED'];
                    const upcomingStatuses = ['SCHEDULED', 'TIMED'];
                    const liveStatuses = ['LIVE', 'IN_PLAY', 'PAUSED'];

                    let statusMatch = false;
                    let matchdayMatch = false;

                    if (statusValue === 'all') {
                        statusMatch = true;
                    } else if (statusValue === 'played') {
                        statusMatch = playedStatuses.includes(status);
                    } else if (statusValue === 'upcoming') {
                        statusMatch = upcomingStatuses.includes(status) || liveStatuses.includes(status);
                    }

                    if (matchdayValue === 'all') {
                        matchdayMatch = true;
                    } else {
                        matchdayMatch = matchday === matchdayValue;
                    }

                    row.style.display = (statusMatch && matchdayMatch) ? 'table-row' : 'none';
                });
            }

            statusFilter.addEventListener('change', filterMatches);
            matchdayFilter.addEventListener('change', filterMatches);
        });
    </script>

</x-app-layout>


