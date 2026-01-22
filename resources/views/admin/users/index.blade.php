<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-white leading-tight">
            Admin panel – Users
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-950 min-h-screen text-slate-100">
        <div class="max-w-7xl mx-auto px-6 flex gap-8">

            {{-- Sidebar --}}
            <aside class="w-52 border-r border-slate-800 pr-4">
                <p class="text-slate-400 uppercase text-xs mb-3">Navigation</p>
                <nav class="space-y-1">
                    <a href="{{ route('games.index') }}"
                       class="block px-3 py-2 rounded-lg text-sm hover:bg-slate-800/80">
                        My games
                    </a>

                    <a href="{{ route('admin.dashboard') }}"
                       class="block px-3 py-2 rounded-lg text-sm hover:bg-slate-800/80">
                        Admin dashboard
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                       class="block px-3 py-2 rounded-lg text-sm bg-slate-800 text-white">
                        Users
                    </a>
                </nav>
            </aside>

            {{-- Main content --}}
            <main class="flex-1">

                {{-- Flash messages --}}
                @if (session('success'))
                    <div class="mb-4 rounded-lg border border-emerald-500/60 bg-emerald-500/10 text-emerald-200 px-4 py-3 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 rounded-lg border border-red-500/60 bg-red-500/10 text-red-200 px-4 py-3 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <h3 class="text-2xl font-semibold">Manage users</h3>

                    <a href="{{ route('admin.users.create') }}"
                       class="inline-flex items-center justify-center px-6 py-2.5
                              bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold
                              rounded-lg shadow-lg shadow-indigo-500/40">
                        Add user
                    </a>
                </div>

                {{-- Search --}}
                <form method="GET"
                      action="{{ route('admin.users.index') }}"
                      class="flex flex-col sm:flex-row gap-3 mb-6">
                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Search by name or email..."
                        class="w-full bg-slate-900 text-slate-100 placeholder-slate-500
                               rounded-lg px-4 py-2.5 border border-slate-700
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    />
                    <button
                        type="submit"
                        class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold rounded-lg">
                        Search
                    </button>
                </form>

                {{-- Users table --}}
                <div class="bg-slate-900 rounded-xl shadow-xl overflow-hidden border border-slate-800">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-900/80 text-slate-300 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3">Name</th>
                                <th class="px-6 py-3">Email</th>
                                <th class="px-6 py-3">Role</th>
                                <th class="px-6 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-slate-100">
                            @forelse ($users as $user)
                                <tr class="border-t border-slate-800 hover:bg-slate-800/70 transition">
                                    <td class="px-6 py-3">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-6 py-3">
                                        <a href="mailto:{{ $user->email }}" class="text-indigo-400">
                                            {{ $user->email }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-3">
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold bg-slate-800">
                                            {{ $user->role ?? 'user' }}
                                        </span>
                                    </td>

                                    {{-- Actions + Delete modal --}}
                                    <td class="px-6 py-3" x-data="{ open: false }">
                                        <div class="flex items-center justify-center gap-3">
                                            {{-- Edit button --}}
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                               class="px-4 py-1.5 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-xs font-semibold">
                                                Edit
                                            </a>

                                            {{-- Delete trigger --}}
                                            <button
                                                type="button"
                                                @click="open = true"
                                                class="px-4 py-1.5 bg-red-600 hover:bg-red-500 text-white rounded-lg text-xs font-semibold">
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
                                                    Delete user
                                                </h3>

                                                <p class="text-sm text-slate-300 mb-4">
                                                    Are you sure you want to delete
                                                    <span class="font-semibold">{{ $user->name }}</span>?
                                                    This action cannot be undone.
                                                </p>

                                                <div class="flex justify-end gap-3">
                                                    <button
                                                        type="button"
                                                        @click="open = false"
                                                        class="px-4 py-2 rounded-lg bg-slate-700 hover:bg-slate-600 text-sm text-slate-100">
                                                        Cancel
                                                    </button>

                                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
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
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-400">
                                        No users found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
