<?php

use App\Models\User;

test('login route redirects to home (login is handled via a modal)', function () {
    $response = $this->get('/login');

    $response->assertRedirect(route('home'));
});

test('users can authenticate using the login endpoint', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    // A user without an admin/lawyer role lands on the public home page.
    $response->assertRedirect(route('home'));
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});
