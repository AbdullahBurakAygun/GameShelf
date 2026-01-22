<?php

namespace App\Http\Controllers;

use App\Models\UserGame;
use App\Models\Genre;
use App\Models\Platform;
use App\Services\GameLibraryService;
use App\Services\GameStatisticsService;
use Illuminate\Http\Request;

class UserGameController extends Controller
{
    public function __construct(
        private readonly GameLibraryService $library,
        private readonly GameStatisticsService $stats
    ) {}

    public function index(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search');

        $userGames = $this->library->listForUser($user, $search);
        $overview  = $this->stats->overviewForUser($user);

        return view('games.index', compact('userGames', 'search', 'overview'));
    }

    public function create()
    {
        $genres    = Genre::orderBy('name')->get();
        $platforms = Platform::orderBy('name')->get();

        return view('games.create', compact('genres', 'platforms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'release_year' => ['nullable', 'integer', 'between:1970,2100'],
            'genre_id'     => ['required', 'exists:genres,id'],
            'platform_id'  => ['required', 'exists:platforms,id'],
            'status'       => ['required', 'in:Playing,Completed,Wishlist'],
        ]);

        
        $this->library->addGameToUserLibrary(auth()->user(), $data, $data['status']);

        return redirect()
            ->route('games.index')
            ->with('success', 'Game added to your library.');
    }

    public function edit(UserGame $game)
    {
     

        $genres    = Genre::orderBy('name')->get();
        $platforms = Platform::orderBy('name')->get();

        return view('games.edit', [
            'userGame'  => $game,
            'genres'    => $genres,
            'platforms' => $platforms,
        ]);
    }

    public function update(Request $request, UserGame $game)
    {
        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'release_year' => ['nullable', 'integer', 'between:1970,2100'],
            'genre_id'     => ['required', 'exists:genres,id'],
            'platform_id'  => ['required', 'exists:platforms,id'],
            'status'       => ['required', 'in:Playing,Completed,Wishlist'],
        ]);

        $this->library->updateUserGame(auth()->user(), $game, $data);

        return redirect()
            ->route('games.index')
            ->with('success', 'Game updated successfully.');
    }

    public function destroy(UserGame $game)
    {
        $this->library->removeFromLibrary(auth()->user(), $game);

        return redirect()
            ->route('games.index')
            ->with('success', 'Game removed from your library.');
    }
}
