<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the Spatie Permission package's gates
        $this->registerSpatiePermissionGates();
    }

    private function registerSpatiePermissionGates(): void
    {
        Gate::before(fn (User $user): bool => $user->hasRole('Super Admin'));
    }
}
