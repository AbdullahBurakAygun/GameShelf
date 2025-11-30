<?php

namespace App\Http\Controllers;

use App\Models\UserGame;
use App\Models\Game;
use App\Models\User;
use App\Models\Genre;
use App\Models\Platform;
use Illuminate\Http\Request;

class UserGameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $user   = auth()->user();
    $search = $request->input('search');

    $query = $user->userGames()
        ->with(['game.genre', 'game.platform'])
        ->orderBy('created_at', 'desc');

    if (!empty($search)) {
        $query->whereHas('game', function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhereHas('genre', function ($genreQuery) use ($search) {
                  $genreQuery->where('name', 'like', "%{$search}%");
              })
              ->orWhereHas('platform', function ($platformQuery) use ($search) {
                  $platformQuery->where('name', 'like', "%{$search}%");
              });
        });
    }

    $userGames = $query->get();

    return view('games.index', compact('userGames', 'search'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genres    = Genre::orderBy('name')->get();
        $platforms = Platform::orderBy('name')->get();

        return view('games.create', [
            'genres'    => $genres,
            'platforms' => $platforms,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'release_year' => ['nullable', 'integer', 'between:1970,2100'],
            'genre_id'     => ['required', 'exists:genres,id'],
            'platform_id'  => ['required', 'exists:platforms,id'],
            'status'       => ['required', 'in:Playing,Completed,Wishlist'],
        ]);
        $game = Game::firstOrCreate([
            'title'        => $data['title'],
            'release_year' => $data['release_year'],
            'genre_id'     => $data['genre_id'],
            'platform_id'  => $data['platform_id'],
        ]);
        UserGame::firstOrCreate([
            'user_id' => $user->id,
            'game_id' => $game->id,
            'status'  => $data['status'],
        ]);

        return redirect()
            ->route('games.index')
            ->with('success', 'Game added to your library.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserGame $game)
    {   
        if ($game->user_id !== auth()->id()) {
            abort(403);
        }

        $genres    = Genre::orderBy('name')->get();
        $platforms = Platform::orderBy('name')->get();

        return view('games.edit', [
            'userGame'  => $game,
            'genres'    => $genres,
            'platforms' => $platforms,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserGame $game)
    {
        
        if ($game->user_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'release_year' => ['nullable', 'integer', 'between:1970,2100'],
            'genre_id'     => ['required', 'exists:genres,id'],
            'platform_id'  => ['required', 'exists:platforms,id'],
            'status'       => ['required', 'in:Playing,Completed,Wishlist'],
        ]);

       
        $gameModel = $game->game;

        $gameModel->update([
            'title'        => $data['title'],
            'release_year' => $data['release_year'],
            'genre_id'     => $data['genre_id'],
            'platform_id'  => $data['platform_id'],
        ]);

       
        $game->update([
            'status' => $data['status'],
        ]);

        return redirect()
            ->route('games.index')
            ->with('success', 'Game updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserGame $game)
    {
        
        if ($game->user_id !== auth()->id()) {
            abort(403);
        }

       
        $game->delete();

        return redirect()
            ->route('games.index')
            ->with('success', 'Game removed from your library.');
    }
}
