<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class GameStatisticsService
{
    public function overviewForUser(User $user): array
    {
        $base = DB::table('user_games')
            ->where('user_id', $user->id);

        $totalGames = (clone $base)->count();

        $byStatus = (clone $base)
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->orderByDesc('total')
            ->get();

        $byGenre = (clone $base)
            ->join('games', 'user_games.game_id', '=', 'games.id')
            ->join('genres', 'games.genre_id', '=', 'genres.id')
            ->select('genres.name as genre', DB::raw('COUNT(*) as total'))
            ->groupBy('genres.name')
            ->orderByDesc('total')
            ->get();

        $byPlatform = (clone $base)
            ->join('games', 'user_games.game_id', '=', 'games.id')
            ->join('platforms', 'games.platform_id', '=', 'platforms.id')
            ->select('platforms.name as platform', DB::raw('COUNT(*) as total'))
            ->groupBy('platforms.name')
            ->orderByDesc('total')
            ->get();

        $completionRate = 0;
        if ($totalGames > 0) {
            $completed = (clone $base)->where('status', 'Completed')->count();
            $completionRate = round(($completed / $totalGames) * 100, 1);
        }

        return [
            'totalGames'     => $totalGames,
            'completionRate' => $completionRate,
            'byStatus'       => $byStatus,
            'byGenre'        => $byGenre,
            'byPlatform'     => $byPlatform,
        ];
    }
}
