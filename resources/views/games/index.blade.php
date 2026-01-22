<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-white leading-tight">
            My games
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-950 min-h-screen text-slate-100">
        <div class="max-w-7xl mx-auto px-6">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <form method="GET" action="{{ route('games.index') }}" class="flex w-full sm:max-w-xl">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by title, genre or platform"
                        class="w-full bg-slate-900 text-slate-100 placeholder-slate-500
                               rounded-lg px-4 py-3 border border-slate-700
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    />
                    <button
                        type="submit"
                        class="ml-4 px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-lg shadow-lg shadow-indigo-500/30">
                        Search
                    </button>
                </form>

                <a href="{{ route('games.create') }}"
                   class="inline-flex items-center justify-center px-8 py-3
                          bg-indigo-600 hover:bg-indigo-500 text-white text-lg font-semibold
                          rounded-xl shadow-lg shadow-indigo-500/40">
                    Add game
                </a>
            </div>

            
            @if(isset($overview))
                <div class="mb-8 bg-slate-900 rounded-xl shadow-xl overflow-hidden border border-slate-800">
                    <div class="px-6 py-5 border-b border-slate-800">
                        <h3 class="text-xl font-semibold text-slate-100">
                            Library overview
                        </h3>
                        <p class="text-sm text-slate-400 mt-1">
                            Statistics based on your library (business logic from service layer).
                        </p>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                            <div class="bg-slate-950/60 border border-slate-800 rounded-xl p-4">
                                <p class="text-slate-400 text-sm">Total games</p>
                                <p class="text-3xl font-bold text-white mt-1">
                                    {{ $overview['totalGames'] }}
                                </p>
                            </div>

                            <div class="bg-slate-950/60 border border-slate-800 rounded-xl p-4">
                                <p class="text-slate-400 text-sm">Completion rate</p>
                                <p class="text-3xl font-bold text-white mt-1">
                                    {{ $overview['completionRate'] }}%
                                </p>
                            </div>

                            <div class="bg-slate-950/60 border border-slate-800 rounded-xl p-4">
                                <p class="text-slate-400 text-sm">Top status</p>
                                <p class="text-3xl font-bold text-white mt-1">
                                    {{ $overview['byStatus']->first()->status ?? '-' }}
                                </p>
                            </div>

                            <div class="bg-slate-950/60 border border-slate-800 rounded-xl p-4">
                                <p class="text-slate-400 text-sm">Most used platform</p>
                                <p class="text-3xl font-bold text-white mt-1">
                                    {{ $overview['byPlatform']->first()->platform ?? '-' }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <div class="bg-slate-950/40 border border-slate-800 rounded-xl p-5">
                                <h4 class="font-semibold text-slate-100 mb-3">By status</h4>
                                <ul class="space-y-2 text-sm">
                                    @forelse($overview['byStatus'] as $row)
                                        <li class="flex items-center justify-between">
                                            <span class="text-slate-300">{{ $row->status }}</span>
                                            <span class="px-3 py-1 rounded-full bg-slate-800 text-slate-100 font-semibold">
                                                {{ $row->total }}
                                            </span>
                                        </li>
                                    @empty
                                        <li class="text-slate-400">No data</li>
                                    @endforelse
                                </ul>
                            </div>

                            <div class="bg-slate-950/40 border border-slate-800 rounded-xl p-5">
                                <h4 class="font-semibold text-slate-100 mb-3">By genre</h4>
                                <ul class="space-y-2 text-sm">
                                    @forelse($overview['byGenre'] as $row)
                                        <li class="flex items-center justify-between">
                                            <span class="text-slate-300">{{ $row->genre }}</span>
                                            <span class="px-3 py-1 rounded-full bg-slate-800 text-slate-100 font-semibold">
                                                {{ $row->total }}
                                            </span>
                                        </li>
                                    @empty
                                        <li class="text-slate-400">No data</li>
                                    @endforelse
                                </ul>
                            </div>

                            <div class="bg-slate-950/40 border border-slate-800 rounded-xl p-5">
                                <h4 class="font-semibold text-slate-100 mb-3">By platform</h4>
                                <ul class="space-y-2 text-sm">
                                    @forelse($overview['byPlatform'] as $row)
                                        <li class="flex items-center justify-between">
                                            <span class="text-slate-300">{{ $row->platform }}</span>
                                            <span class="px-3 py-1 rounded-full bg-slate-800 text-slate-100 font-semibold">
                                                {{ $row->total }}
                                            </span>
                                        </li>
                                    @empty
                                        <li class="text-slate-400">No data</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-slate-900 rounded-xl shadow-xl overflow-hidden border border-slate-800">
                <table class="w-full text-left">
                    <thead class="bg-slate-900/80 text-slate-300 text-sm uppercase">
                        <tr>
                            <th class="px-6 py-4">Title</th>
                            <th class="px-6 py-4">Year</th>
                            <th class="px-6 py-4">Genre</th>
                            <th class="px-6 py-4">Platform</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="text-slate-100 text-sm">
                        @forelse ($userGames as $userGame)
                            <tr class="border-t border-slate-800 hover:bg-slate-800/70 transition">
                                <td class="px-6 py-4">
                                    {{ $userGame->game->title }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $userGame->game->release_year ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $userGame->game->genre->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $userGame->game->platform->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold bg-slate-800">
                                        {{ $userGame->status ?? '-' }}
                                    </span>
                                </td>

                                {{-- Actions + Delete modal --}}
                                <td class="px-6 py-4" x-data="{ open: false }">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('games.edit', $userGame) }}"
                                           class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-xs font-semibold">
                                            Edit
                                        </a>

                                        <button
                                            type="button"
                                            @click="open = true"
                                            class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-lg text-xs font-semibold">
                                            Delete
                                        </button>
                                    </div>

                                    {{-- Modal --}}
                                    <div
                                        x-cloak
                                        x-show="open"
                                        x-transition
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60"
                                    >
                                        <div
                                            @click.away="open = false"
                                            class="bg-slate-900 border border-slate-700 rounded-xl shadow-xl max-w-md w-full mx-4 p-6"
                                        >
                                            <h3 class="text-lg font-semibold text-slate-100 mb-2">
                                                Delete game
                                            </h3>

                                            <p class="text-sm text-slate-300 mb-4">
                                                Are you sure you want to delete
                                                <span class="font-semibold">{{ $userGame->game->title }}</span>?
                                                This action cannot be undone.
                                            </p>

                                            <div class="flex justify-end gap-3">
                                                <button
                                                    type="button"
                                                    @click="open = false"
                                                    class="px-4 py-2 rounded-lg bg-slate-700 hover:bg-slate-600 text-sm text-slate-100">
                                                    Cancel
                                                </button>

                                                <form method="POST" action="{{ route('games.destroy', $userGame) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-500 text-sm text-white font-semibold">
                                                    Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                                    You have no games yet.
                                    Click
                                    <a href="{{ route('games.create') }}" class="text-indigo-400 font-semibold">
                                        Add game
                                    </a>
                                    to start your library.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
