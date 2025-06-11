<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
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
        $this->rateLimitWebRoutes();
    }

    private function registerSpatiePermissionGates(): void
    {
        Gate::before(fn(User $user): bool => $user->hasRole('Super Admin'));
    }

    private function rateLimitWebRoutes(): void
    {
        RateLimiter::for('auth-limit', function (Request $request) {
            return Limit::perMinute(config('auth.rate_limits.login.max_attempts'), config('auth.rate_limits.login.decay_minutes'))
                ->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    return response('Too many login attempts. Please try again later.', Response::HTTP_TOO_MANY_REQUESTS, $headers);
                });
        });
    }
}
