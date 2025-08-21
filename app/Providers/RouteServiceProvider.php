<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/JADBudget/dashboard'; // Adjust if your dashboard path is different

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // IMPORTANT: This line calls the method that defines your rate limiters.
        $this->configureRateLimiting();

        // This block registers your route files and middleware groups.
        // In Laravel 11, the primary routing is often handled by bootstrap/app.php,
        // but keeping this here ensures consistency with the service provider's role.
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    protected function configureRateLimiting(): void
    {
        // Define a rate limiter named 'login_attempts'
        // Allows 5 requests per minute, uniquely identified by the client's IP address.
        RateLimiter::for('login_attempts', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // Define a rate limiter named 'signin_attempts'
        // Allows 3 requests per minute, uniquely identified by the client's IP address.
        RateLimiter::for('signin_attempts', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip());
        });

        RateLimiter::for('contact_attemps', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip());
        });

        // You can add more custom rate limiters here if needed.
    }
}
