<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-white leading-tight">
            Add game
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-950 min-h-screen text-slate-100">
        <div class="max-w-3xl mx-auto px-6">
         
            <div class="bg-slate-900 border border-slate-800 rounded-xl shadow-xl p-8">

                
                @if ($errors->any())
                    <div class="mb-6 rounded-lg border border-red-500/60 bg-red-500/10 text-red-200 px-4 py-3 text-sm">
                        <p class="font-semibold mb-1">There were some problems with your input:</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('games.store') }}" class="space-y-6">
                    @csrf

                    {{-- Title --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-200 mb-1">
                            Title
                        </label>
                        <input
                            type="text"
                            name="title"
                            value="{{ old('title') }}"
                            class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3
                                   text-slate-100 placeholder-slate-500
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="E.g. The Witcher 3"
                            required
                        >
                    </div>

                    {{-- Release year --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-200 mb-1">
                            Release year (optional)
                        </label>
                        <input
                            type="number"
                            name="release_year"
                            value="{{ old('release_year') }}"
                            class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3
                                   text-slate-100 placeholder-slate-500
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="2020"
                        >
                    </div>

                    {{-- Genre --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-200 mb-1">
                            Genre
                        </label>
                        <select
                            name="genre_id"
                            class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3
                                   text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            required
                        >
                            <option value="" disabled {{ old('genre_id') ? '' : 'selected' }}>
                                Select a genre
                            </option>
                            @foreach ($genres as $genre)
                                <option value="{{ $genre->id }}" @selected(old('genre_id') == $genre->id)>
                                    {{ $genre->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Platform --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-200 mb-1">
                            Platform
                        </label>
                        <select
                            name="platform_id"
                            class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3
                                   text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            required
                        >
                            <option value="" disabled {{ old('platform_id') ? '' : 'selected' }}>
                                Select a platform
                            </option>
                            @foreach ($platforms as $platform)
                                <option value="{{ $platform->id }}" @selected(old('platform_id') == $platform->id)>
                                    {{ $platform->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-200 mb-1">
                            Status
                        </label>
                        <select
                            name="status"
                            class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3
                                   text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            required
                        >
                            @php
                                $statuses = ['Playing', 'Completed', 'Wishlist'];
                                $selectedStatus = old('status', 'Playing');
                            @endphp

                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @selected($selectedStatus === $status)>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-center justify-end gap-4 pt-4">
                        <a href="{{ route('games.index') }}"
                           class="px-5 py-2.5 rounded-lg border border-slate-600 text-slate-200
                                  hover:bg-slate-800/80 text-sm font-medium">
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="px-6 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-500
                                   text-white text-sm font-semibold shadow-lg shadow-indigo-500/40">
                            Save game
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
