<?php

use App\Models\User;
use App\Models\Genre;
use App\Models\Platform;

it('creates a game when valid data is provided', function () {
    $user = User::factory()->create();

    $genre = Genre::factory()->create();
    $platform = Platform::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/games', [
            'title'        => 'Test Game',
            'release_year' => 2024,
            'genre_id'     => $genre->id,
            'platform_id'  => $platform->id,
            'status'       => 'Playing',
        ]);

    $response->assertRedirect(route('games.index'));
    $response->assertSessionHas('success');
});
