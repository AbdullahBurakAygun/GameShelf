<?php

namespace App\Services;

use App\Models\Game;
use App\Models\User;
use App\Models\UserGame;
use Illuminate\Support\Facades\DB;

class GameLibraryService
{
    public function addGameToUserLibrary(User $user, array $data, string $status = 'Playing'): UserGame
    {
        return DB::transaction(function () use ($user, $data, $status) {

            $game = Game::firstOrCreate([
                'title'        => $data['title'],
                'release_year' => $data['release_year'] ?? null,
                'genre_id'     => $data['genre_id'],
                'platform_id'  => $data['platform_id'],
            ]);

            return UserGame::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'game_id' => $game->id,
                ],
                [
                    'status' => $status,
                ]
            );
        });
    }

    public function listForUser(User $user, ?string $search = null)
    {
        $query = $user->userGames()
            ->with(['game.genre', 'game.platform'])
            ->orderBy('created_at', 'desc');

        if (!empty($search)) {
            $query->whereHas('game', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('genre', fn ($g) => $g->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('platform', fn ($p) => $p->where('name', 'like', "%{$search}%"));
            });
        }

        return $query->get();
    }

    public function updateUserGame(User $user, UserGame $userGame, array $data): void
    {
        $this->ensureOwner($user, $userGame);

        DB::transaction(function () use ($userGame, $data) {
            $userGame->game->update([
                'title'        => $data['title'],
                'release_year' => $data['release_year'] ?? null,
                'genre_id'     => $data['genre_id'],
                'platform_id'  => $data['platform_id'],
            ]);

            $userGame->update([
                'status' => $data['status'],
            ]);
        });
    }

    public function removeFromLibrary(User $user, UserGame $userGame): void
    {
        $this->ensureOwner($user, $userGame);
        $userGame->delete();
    }

    private function ensureOwner(User $user, UserGame $userGame): void
    {
        if ($userGame->user_id !== $user->id) {
            abort(403);
        }
    }
}
