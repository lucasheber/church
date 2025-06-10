<?php

declare(strict_types=1);

beforeEach(function (): void {
    // Ensure the Spatie Permission package is set up correctly
    $pastorRole               = Spatie\Permission\Models\Role::findOrCreate('pastor');
    $secretaryRole            = Spatie\Permission\Models\Role::findOrCreate('secretary');
    $adminRole                = Spatie\Permission\Models\Role::findOrCreate('Super Admin');
    $createMembersPermission  = Spatie\Permission\Models\Permission::findOrCreate('create members');
    $editMembersPermission    = Spatie\Permission\Models\Permission::findOrCreate('edit members');
    $deleteMembersPermission  = Spatie\Permission\Models\Permission::findOrCreate('delete members');
    $viewMembersPermission    = Spatie\Permission\Models\Permission::findOrCreate('view members');
    $attendanceListPermission = Spatie\Permission\Models\Permission::findOrCreate('attendance list');

    $pastorRole->givePermissionTo($createMembersPermission);
    $pastorRole->givePermissionTo($editMembersPermission);
    $pastorRole->givePermissionTo($deleteMembersPermission);
    $pastorRole->givePermissionTo($viewMembersPermission);
    $secretaryRole->givePermissionTo($attendanceListPermission);

});

it('create a role and permission', function (): void {
    $this->pastorRole            = Spatie\Permission\Models\Role::findOrCreate('pastor');
    $this->editMembersPermission = Spatie\Permission\Models\Permission::findOrCreate('edit members');
    $this->pastorRole->givePermissionTo($this->editMembersPermission);
    $this->pastorRole->save();

    expect($this->pastorRole)->toBeInstanceOf(Spatie\Permission\Models\Role::class);
    expect($this->editMembersPermission)->toBeInstanceOf(Spatie\Permission\Models\Permission::class);
    expect($this->pastorRole->name)->toBe('pastor');
    expect($this->editMembersPermission->name)->toBe('edit members');
});

it('assign a role to a user', function (): void {
    $user = App\Models\User::factory()->create();

    $user->assignRole('pastor');
    expect($user->hasRole('pastor'))->toBeTrue();
});

it('not assign a role to a user if the role does not exist', function (): void {
    $user = App\Models\User::factory()->create();

    expect(fn () => $user->assignRole('nonexistent_role'))->toThrow(Spatie\Permission\Exceptions\RoleDoesNotExist::class);
});

it('validate if a user has a role', function (): void {
    $user = App\Models\User::factory()->create();
    $user->assignRole('pastor');

    expect($user->hasRole('pastor'))->toBeTrue();
    expect($user->hasRole('secretary'))->toBeFalse();
});

it('validate if a user does not have a role', function (): void {
    $user = App\Models\User::factory()->create();

    expect($user->hasRole('pastor'))->toBeFalse();
});

it('assign multiple roles to a user', function (): void {
    $user = App\Models\User::factory()->create();

    $user->assignRole(['pastor', 'secretary']);
    expect($user->hasRole('pastor'))->toBeTrue();
    expect($user->hasRole('secretary'))->toBeTrue();
    expect($user->getRoleNames()->toArray())->toContain('pastor');
    expect($user->getRoleNames()->toArray())->toContain('secretary');
});

it('should not permit a secretary to create members', function (): void {
    $user = App\Models\User::factory()->create();
    $user->assignRole('secretary');
    expect($user->can('create members'))->toBeFalse();
});

it('should permit a pastor to create members', function (): void {
    $user = App\Models\User::factory()->create();
    $user->assignRole('pastor');
    expect($user->can('create members'))->toBeTrue();
});

it('should not permit a secretary to edit members', function (): void {
    $user = App\Models\User::factory()->create();
    $user->assignRole('secretary');
    expect($user->can('edit members'))->toBeFalse();
});

it('should permit an admin to edit members', function (): void {
    $user = App\Models\User::factory()->create();
    $user->assignRole('Super Admin');
    expect($user->can('edit members'))->toBeTrue();
});
