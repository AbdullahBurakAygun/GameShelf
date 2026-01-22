<?php

namespace App\Services;

use App\Models\UserGame;

class UserGameService
{
    public function setStatus(UserGame $userGame, string $status): UserGame
    {
        $userGame->status = $status;

        if ($status === 'Completed') {
            $userGame->completed_at = now();
        } else {
            $userGame->completed_at = null;
        }

        $userGame->save();

        return $userGame;
    }
}
