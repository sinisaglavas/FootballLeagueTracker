<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between bg-white shadow-sm sm:rounded-2xl p-6">
                <div class="p-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard</h1>
                    <p class="text-gray-600">Manage your favorite football teams.</p>
                </div>

                <div class="p-6 mt-4">
                    <a href="{{ route('competitions.index') }}"
                       class="border border-green-800 px-6 py-2 rounded-xl font-semibold text-lg hover:border-gray-300 hover:text-green-700 transition">
                        View Competitions
                    </a>
                </div>
            </div>


            <div class="bg-white shadow-sm sm:rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900">Active Favorite Teams</h2>
                    <span class="text-sm text-gray-500">
                        {{ $favoriteTeams->count() }} teams
                    </span>
                </div>

                @if($favoriteTeams->isEmpty())
                    <div class="border border-dashed border-gray-300 rounded-2xl p-8 text-center text-gray-500">
                        You do not have any favorite teams yet.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($favoriteTeams as $favoriteTeam)
                            <div class="border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                                <div class="flex items-center gap-4 mb-4">
                                    @if($favoriteTeam->favorite_team_crest)
                                        <img
                                            src="{{ $favoriteTeam->favorite_team_crest }}"
                                            alt="{{ $favoriteTeam->favorite_team_name }}"
                                            class="w-16 h-16 object-contain"
                                        >
                                    @endif

                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">
                                            {{ $favoriteTeam->favorite_team_name }}
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            {{ $favoriteTeam->favorite_team_country ?? 'Unknown country' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between gap-3">
                                    <a
                                        href="{{ route('competitions.show', $favoriteTeam->favorite_team_id) }}"
                                        class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
                                    >
                                        View team
                                    </a>

                                    <form method="POST" action="{{ route('favorite-teams.destroy', $favoriteTeam) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700"
                                        >
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="bg-white shadow-sm sm:rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900">Removed Favorite Teams</h2>
                    <span class="text-sm text-gray-500">
                        {{ $removedFavoriteTeams->count() }} removed
                    </span>
                </div>

                @if($removedFavoriteTeams->isEmpty())
                    <div class="border border-dashed border-gray-300 rounded-2xl p-8 text-center text-gray-500">
                        There are no removed teams.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 border text-left">Team</th>
                                <th class="px-4 py-3 border text-left">Country</th>
                                <th class="px-4 py-3 border text-left">Deleted at</th>
                                <th class="px-4 py-3 border text-left">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($removedFavoriteTeams as $favoriteTeam)
                                <tr>
                                    <td class="px-4 py-3 border">
                                        <div class="flex items-center gap-3">
                                            @if($favoriteTeam->favorite_team_crest)
                                                <img
                                                    src="{{ $favoriteTeam->favorite_team_crest }}"
                                                    alt="{{ $favoriteTeam->favorite_team_name }}"
                                                    class="w-10 h-10 object-contain"
                                                >
                                            @endif

                                            <span class="font-medium text-gray-900">
                                                    {{ $favoriteTeam->favorite_team_name }}
                                                </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 border">
                                        {{ $favoriteTeam->favorite_team_country ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 border">
                                        {{ optional($favoriteTeam->deleted_at)->format('d.m.Y H:i') }}
                                    </td>
                                    <td class="px-4 py-3 border">
                                        <div class="flex flex-wrap gap-2">
                                            <form method="POST" action="{{ route('favorite-teams.restore', $favoriteTeam->id) }}">
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center rounded-lg bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-green-700"
                                                >
                                                    Restore
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('favorite-teams.force-delete', $favoriteTeam->id) }}">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="inline-flex items-center rounded-lg bg-gray-800 px-3 py-2 text-sm font-medium text-white hover:bg-black">
                                                    Delete permanently
                                                </button>
                                            </form>
                                        </div>
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
