<?php

use App\Models\User;

it('validates required fields when creating a game', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/games', [
          
        ]);

    $response->assertStatus(302);

    $response->assertSessionHasErrors([
        'title',
        'genre_id',
        'platform_id',
        'status',
    ]);
});
it('validates title length when creating a game', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/games', [
            'title' => str_repeat('A', 256), 
            'genre_id' => 1,
            'platform_id' => 1,
            'status' => 'playing',
        ]);

    $response->assertStatus(302);

    $response->assertSessionHasErrors([
        'title',
    ]);
});