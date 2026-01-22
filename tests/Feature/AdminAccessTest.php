<?php

use App\Models\User;

it('blocks non-admin users from admin area', function () {
    $user = User::factory()->create(['role' => 'user']);

    $response = $this->actingAs($user)->get('/admin/users');

   
    $response->assertForbidden();
});

it('allows admin users to access admin users index', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get('/admin/users');

    $response->assertOk();
});
it('redirects guests from admin area to login', function () {
    $response = $this->get('/admin/users');

    $response->assertRedirect('/login');
});
