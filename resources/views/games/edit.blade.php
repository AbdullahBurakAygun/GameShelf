<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-white leading-tight">
            Edit game
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-950 min-h-screen text-slate-100">
        <div class="max-w-3xl mx-auto px-6">

            <div class="bg-slate-900 rounded-xl shadow-xl border border-slate-800 p-8">
                <form method="POST" action="{{ route('games.update', $userGame) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Title --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Title
                        </label>
                        <input
                            type="text"
                            name="title"
                            value="{{ old('title', $userGame->game->title) }}"
                            class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-2.5
                                   text-slate-100 placeholder-slate-500
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        />
                        @error('title')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Genre --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Genre
                        </label>
                        <select
                            name="genre_id"
                            class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-2.5
                                   text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Select a genre</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre->id }}"
                                    @selected(old('genre_id', $userGame->game->genre_id) == $genre->id)>
                                    {{ $genre->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('genre_id')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Platform --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Platform
                        </label>
                        <select
                            name="platform_id"
                            class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-2.5
                                   text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Select a platform</option>
                            @foreach($platforms as $platform)
                                <option value="{{ $platform->id }}"
                                    @selected(old('platform_id', $userGame->game->platform_id) == $platform->id)>
                                    {{ $platform->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('platform_id')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Release year --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Release year (optional)
                        </label>
                        <input
                            type="number"
                            name="release_year"
                            value="{{ old('release_year', $userGame->game->release_year) }}"
                            class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-2.5
                                   text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        @error('release_year')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Status
                        </label>
                        <select
                            name="status"
                            class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-2.5
                                   text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @php
                                $currentStatus = old('status', $userGame->status);
                            @endphp
                            <option value="Playing"   @selected($currentStatus === 'Playing')>Playing</option>
                            <option value="Completed" @selected($currentStatus === 'Completed')>Completed</option>
                            <option value="Wishlist"  @selected($currentStatus === 'Wishlist')>Wishlist</option>
                        </select>
                        @error('status')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('games.index') }}"
                           class="px-5 py-2.5 rounded-lg border border-slate-600 text-slate-200 text-sm">
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold rounded-lg shadow-lg shadow-indigo-500/40">
                            Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

