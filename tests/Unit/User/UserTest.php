<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

it('has a name', function () {
    $user = User::factory()->create();

    expect($user->name)->toBeString();
});

it('has an email', function () {
    $user = User::factory()->create();

    expect($user->email)->toBeString();
});

it('has a password', function () {
    $user = User::factory()->create();

    expect($user->password)->toBeString();
});

it('can be created with a factory', function () {
    $user = User::factory()->create();

    expect($user)->toBeInstanceOf(User::class);
    expect($user->exists)->toBeTrue();
});

it('can be updated', function () {
    $user = User::factory()->create();

    $user->name = 'Updated Name';
    $user->save();

    expect($user->name)->toBe('Updated Name');
});

it('can be force deleted', function () {
    $user = User::factory()->create();

    $user->forceDelete();

    expect($user->exists)->toBeFalse();
});

it('can be found by email', function () {
    $user = User::factory()->create();

    $foundUser = User::where('email', $user->email)->first();

    expect($foundUser)->toBeInstanceOf(User::class);
    expect($foundUser->id)->toBe($user->id);
});


it('can be authenticated', function () {
    $user = User::factory()->create();

    $this->actingAs($user);
    expect(Auth::user()->id)->toBe($user->id);
});

it('can be soft deleted', function () {
    $user = User::factory()->create();

    $user->delete();

    expect($user->trashed())->toBeTrue();
});

it('can be restored after soft delete', function () {
    $user = User::factory()->create();

    $user->delete();
    $user->restore();

    expect($user->trashed())->toBeFalse();
});

it('can hash password on creation', function () {
    $user = User::factory()->create(['password' => 'plain-text-password']);

    expect($user->password)->not->toBe('plain-text-password');
    expect(Hash::check('plain-text-password', $user->password))->toBeTrue();
});
