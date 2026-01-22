<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-white leading-tight">
            Admin panel – Add user
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-950 min-h-screen text-slate-100">
        <div class="max-w-4xl mx-auto px-6">

            {{-- Hatalar --}}
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

            <div class="bg-slate-900 border border-slate-800 rounded-xl shadow-xl p-8">

                <h3 class="text-2xl font-semibold mb-6">Add user</h3>

                <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
                    @csrf

                    {{-- Name --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-200 mb-1">
                            Name
                        </label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3
                                   text-slate-100 placeholder-slate-500
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="John Doe"
                            required
                        >
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-200 mb-1">
                            Email
                        </label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3
                                   text-slate-100 placeholder-slate-500
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="user@example.com"
                            required
                        >
                    </div>

                    {{-- Role --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-200 mb-1">
                            Role
                        </label>
                        <select
                            name="role"
                            class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3
                                   text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            required
                        >
                            @php
                                $role = old('role', 'user');
                            @endphp
                            <option value="admin" @selected($role === 'admin')>Admin</option>
                            <option value="user"  @selected($role === 'user')>User</option>
                        </select>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-200 mb-1">
                            Password
                        </label>
                        <input
                            type="password"
                            name="password"
                            class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3
                                   text-slate-100 placeholder-slate-500
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="Min. 8 characters"
                            required
                        >
                    </div>

                    {{-- Confirm password (controller confirmed yaptığı için lazım) --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-200 mb-1">
                            Confirm password
                        </label>
                        <input
                            type="password"
                            name="password_confirmation"
                            class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3
                                   text-slate-100 placeholder-slate-500
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            required
                        >
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
                                $status = old('status', 'active');
                            @endphp
                            <option value="active"   @selected($status === 'active')>Active</option>
                            <option value="inactive" @selected($status === 'inactive')>Inactive</option>
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-center gap-4 pt-4">
                        <button
                            type="submit"
                            class="px-6 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-500
                                   text-white text-sm font-semibold shadow-lg shadow-indigo-500/40">
                            Save
                        </button>

                        <a href="{{ route('admin.users.index') }}"
                           class="px-6 py-2.5 rounded-lg bg-red-600 hover:bg-red-500
                                  text-white text-sm font-semibold">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
