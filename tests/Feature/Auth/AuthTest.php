<?php

declare(strict_types=1);

use Inertia\Testing\AssertableInertia as Assert;

it('can access the login page', function (): void {
    $response = $this->get(route('login'));

    $response->assertOk()
        ->assertInertia(
            fn (Assert $page): Assert => $page
            ->component('Auth/Login')
        );
});

it('can login with valid credentials', function (): void {
    $user = App\Models\User::factory()->create([
        'email'    => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->post(route('login.post'), [
        'email'    => 'test@example.com',
        'password' => 'password',
    ]);

    $response->assertRedirect(route('dashboard.index'));
    $this->assertAuthenticatedAs($user);
});

it('cannot login with invalid credentials', function (): void {
    $response = $this->post(route('login.post'), [
        'email'    => 'invalid@example.com',
        'password' => 'invalidpassword',
    ]);

    $response->assertRedirect(route('login'));
    $response->assertSessionHasErrors(['message' => 'The provided credentials do not match our records.']);
    $this->assertGuest();
});

it('can logout successfully', function (): void {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('logout'));

    $response->assertRedirect(route('login'));
    $response->assertSessionHas('success', 'You have been logged out successfully.');
    $this->assertGuest();
});

it('can access the registration page', function (): void {
    $response = $this->get(route('register'));

    $response->assertOk()
        ->assertInertia(
            fn (Assert $page): Assert => $page
            ->component('Auth/Register')
        );
});

it('can register a new user', function (): void {
    $response = $this->post(route('register.post'), [
        'name'     => 'Test User',
        'email'    => 'test@example.com',
        'password' => 'password',
    ]);

    $response->assertRedirect(route('dashboard.index'));
    $this->assertAuthenticated();
});
it('cannot register with existing email', function (): void {
    App\Models\User::factory()->create(['email' => 'test@example.com']);

    $response = $this->post(route('register.post'), [
        'name'     => 'Test User',
        'email'    => 'test@example.com',
        'password' => 'password',
    ]);

    $response->assertRedirect(route('register'));
    $response->assertSessionHasErrors(['email' => 'The email has already been taken.']);
});

it('cannot register with invalid password', function (): void {
    $response = $this->post(route('register.post'), [
        'name'     => 'Test User',
        'email'    => 'test@example.com',
        'password' => 'short',
    ]);

    $response->assertRedirect(route('register'));
    $response->assertSessionHasErrors(['password' => 'The password must be at least 8 characters.']);
});

it('cannot access dashboard without authentication', function (): void {
    $response = $this->get(route('dashboard.index'));

    $response->assertRedirect(route('login'));
});

it('can access dashboard when authenticated', function (): void {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard.index'));

    $response->assertOk()
        ->assertJson(['message' => 'Welcome to the Dashboard!']);
});
