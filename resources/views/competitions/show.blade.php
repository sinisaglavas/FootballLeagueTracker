<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <div class="flex flex-col md:flex-row md:items-center gap-6 mb-8">
                    <div class="shrink-0">
                        @if(!empty($team['crest']))
                            <img src="{{ $team['crest'] }}" alt="{{ $team['name'] }}" class="w-24 h-24 object-contain">
                        @endif
                    </div>

                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">
                            {{ $team['name'] ?? 'Team' }}
                        </h1>

                        <div class="mt-3 space-y-1 text-gray-700">
                            <p><span class="font-semibold">Short name:</span> {{ $team['shortName'] ?? '-' }}</p>
                            <p><span class="font-semibold">TLA:</span> {{ $team['tla'] ?? '-' }}</p>
                            <p><span class="font-semibold">Founded:</span> {{ $team['founded'] ?? '-' }}</p>
                            <div class="mb-6 p-4 border rounded bg-gray-50">
                                <h2 class="text-xl font-semibold mb-2">Stadium</h2>
                                <p class="text-gray-700">{{ $team['venue'] ?? '-' }}</p>
                            </div>
                            <p><span class="font-semibold">Address:</span> {{ $team['address'] ?? '-' }}</p>
                            <p><span class="font-semibold">Website:</span>
                                @if(!empty($team['website']))
                                    <a href="{{ $team['website'] }}" target="_blank" class="text-blue-600 hover:underline">
                                        {{ $team['website'] }}
                                    </a>
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mb-6 p-4 border rounded bg-gray-50">
                    <h2 class="text-xl font-semibold mb-3">👨‍🏫 Coach</h2>

                    @if(empty($coach))
                        <p class="text-gray-600">No coach data available.</p>
                    @else
                        <div class="space-y-1 text-gray-700">
                            <p>
                                <span class="font-semibold">Name:</span>
                                {{ $coach['name'] ?? '-' }}
                            </p>

                            <p>
                                <span class="font-semibold">Nationality:</span>
                                {{ $coach['nationality'] ?? '-' }}
                            </p>

                            <p>
                                <span class="font-semibold">Date of Birth:</span>
                                @if(!empty($coach['dateOfBirth']))
                                    {{ \Carbon\Carbon::parse($coach['dateOfBirth'])->format('d.m.Y.') }}
                                @else
                                    -
                                @endif
                            </p>

                            <div class="mb-6 flex p-4 gap-4 border rounded bg-gray-50">
                                <h4 class="font-semibold">Contract:</h4>
                                <p>{{ \Carbon\Carbon::parse($coach['contract']['start'])->format('m.Y.') ?? '-' }}</p>
                                <p>-</p>
                                <p>{{ \Carbon\Carbon::parse($coach['contract']['until'])->format('m.Y.') ?? '-' }}</p>
                            </div>

                        </div>
                    @endif
                </div>

                <div class="mb-4">
                    <h2 class="text-2xl font-semibold text-gray-900">Squad</h2>
                </div>

                @if(empty($squad))
                    <p class="text-gray-600">No squad data available.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 py-2 border text-left">Name</th>
                                <th class="px-3 py-2 border text-left">Position</th>
                                <th class="px-3 py-2 border text-left">Nationality</th>
                                <th class="px-3 py-2 border text-left">Date of Birth</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($squad as $player)
                                <tr>
                                    <td class="px-3 py-2 border">{{ $player['name'] ?? '-' }}</td>
                                    <td class="px-3 py-2 border">{{ $player['position'] ?? '-' }}</td>
                                    <td class="px-3 py-2 border">{{ $player['nationality'] ?? '-' }}</td>
                                    <td class="px-3 py-2 border">
                                        @if(!empty($player['dateOfBirth']))
                                            {{ \Carbon\Carbon::parse($player['dateOfBirth'])->format('d.m.Y.') }}
                                        @else
                                            -
                                        @endif
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
