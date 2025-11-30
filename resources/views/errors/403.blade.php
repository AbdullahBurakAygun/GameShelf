@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-slate-950 text-slate-100 flex items-center justify-center">
        <div class="max-w-lg w-full bg-slate-900 border border-slate-800 rounded-xl p-8 text-center shadow-xl">
            <h1 class="text-3xl font-bold mb-4">Access denied</h1>

            <p class="mb-4">
                You tried to access a page or game that does not belong to your account.
            </p>

            <p class="text-sm text-slate-400 mb-6">
                For security reasons you can only view and edit your own games.
            </p>

            <a href="{{ route('games.index') }}"
               class="inline-flex px-6 py-3 bg-indigo-600 hover:bg-indigo-500 rounded-lg font-semibold">
                Go back to My games
            </a>
        </div>
    </div>
@endsection
