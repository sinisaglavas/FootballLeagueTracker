@extends('layout')

@section('content')

    <x-app-layout>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h1 class="text-2xl font-bold mb-6">Competitions</h1>

                    @if(empty($competitions))
                        <p>No competitions found.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-200">
                                <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 border">Name</th>
                                    <th class="px-4 py-2 border">Match review</th>
                                    <th class="px-4 py-2 border">Code</th>
                                    <th class="px-4 py-2 border">Type</th>
                                    <th class="px-4 py-2 border">Area</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($competitions as $competition)
                                    <tr>
                                        <td class="px-4 py-2 border">
                                            <a href="{{ route('competitions.standings', [$competition['code']]) }}" class="text-blue-600 hover:underline">{{ $competition['name'] ?? '-' }}</a>
                                        </td>
                                        <td class="px-4 py-2 border">
                                            <a href="{{ route('competitions.matches', $competition['code']) }}" class="text-green-600 hover:underline">
                                                Matches
                                            </a>
                                        </td>
                                        <td class="px-4 py-2 border">
                                            {{ $competition['code'] ?? '-' }}
                                        </td>
                                        <td class="px-4 py-2 border">
                                            {{ $competition['type'] ?? '-' }}
                                        </td>
                                        <td class="px-4 py-2 border">
                                            {{ $competition['area']['name'] ?? '-' }}
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
