<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-white leading-tight">
            Admin panel – Dashboard
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
                       class="block px-3 py-2 rounded-lg text-sm bg-slate-800 text-white">
                        Admin dashboard
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                       class="block px-3 py-2 rounded-lg text-sm hover:bg-slate-800/80">
                        Users
                    </a>
                </nav>
            </aside>

            {{-- Main content --}}
            <main class="flex-1">

                <h3 class="text-2xl font-semibold mb-6">Overview</h3>

                {{-- Stat cards --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                    <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 shadow-lg">
                        <p class="text-sm text-slate-400 mb-1">Total users</p>
                        <p class="text-3xl font-bold">{{ $totalUsers }}</p>
                    </div>

                    <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 shadow-lg">
                        <p class="text-sm text-slate-400 mb-1">Admins</p>
                        <p class="text-3xl font-bold">{{ $totalAdmins }}</p>
                    </div>

                    <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 shadow-lg">
                        <p class="text-sm text-slate-400 mb-1">Games</p>
                        <p class="text-3xl font-bold">{{ $totalGames }}</p>
                    </div>
                </div>

                {{-- Latest users table --}}
                <div class="bg-slate-900 border border-slate-800 rounded-xl shadow-xl overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-800">
                        <h4 class="font-semibold text-lg">Recently added users</h4>
                        <a href="{{ route('admin.users.index') }}" class="text-sm text-indigo-400 hover:text-indigo-300">
                            View all
                        </a>
                    </div>

                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-900/80 text-slate-300 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3">Name</th>
                                <th class="px-6 py-3">Email</th>
                                <th class="px-6 py-3">Role</th>
                                <th class="px-6 py-3">Created</th>
                            </tr>
                        </thead>
                        <tbody class="text-slate-100">
                            @forelse ($latestUsers as $user)
                                <tr class="border-t border-slate-800">
                                    <td class="px-6 py-3">{{ $user->name }}</td>
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
                                    <td class="px-6 py-3 text-slate-400 text-xs">
                                        {{ $user->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-6 text-center text-slate-400">
                                        No users yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </main>
        </div>
    </div>
</x-app-layout>
