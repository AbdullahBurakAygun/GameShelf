<?php

use App\Models\User;

it('redirects guests from games index to login', function () {
    $response = $this->get('/games');
    $response->assertRedirect('/login');
});

it('allows authenticated users to open games index', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/games');
    $response->assertOk();
});
