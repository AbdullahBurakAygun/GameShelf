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

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('games.edit', $userGame) }}"
                                           class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-xs font-semibold">
                                            Edit
                                        </a>

                                        <form action="{{ route('games.destroy', $userGame) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-lg text-xs font-semibold">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-400">
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
