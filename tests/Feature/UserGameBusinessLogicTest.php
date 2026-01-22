<?php

use App\Models\User;
use App\Models\Genre;
use App\Models\Platform;
use App\Models\UserGame;

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);


it('it sets completed_at when status is set to Completed', function () {
    $user = User::factory()->create();

  
    $genre = Genre::first();
    $platform = Platform::first();

    if (! $genre || ! $platform) {
        $this->seed(); 
        $genre = Genre::first();
        $platform = Platform::first();
    }

    $this->actingAs($user)->post('/games', [
        'title' => 'Logic Test Game',
        'release_year' => 2024,
        'genre_id' => $genre->id,
        'platform_id' => $platform->id,
        'status' => 'Playing',
    ])->assertRedirect(route('games.index'));

    $userGame = UserGame::where('user_id', $user->id)->latest()->first();

    $this->actingAs($user)->patch("/games/{$userGame->id}", [
        'title' => 'Logic Test Game Updated',
        'release_year' => 2024,
        'genre_id' => $genre->id,
        'platform_id' => $platform->id,
        'status' => 'Completed',
    ])->assertStatus(302);

    $userGame->refresh();

    expect($userGame->completed_at)->not->toBeNull();
});
