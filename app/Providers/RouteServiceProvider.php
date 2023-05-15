<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\{RateLimiter, Route};
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
	/**
	 * Define your route model bindings, pattern filters, and other route configuration.
	 *
	 * @return void
	 */
	public function boot(): void
	{
		$this->configureRateLimiting();

		$this->routes(function () {
			Route::middleware('api')
				->prefix('api')
				->group(base_path('routes/api.php'));
		});
	}

	/**
	 * Configure the rate limiters for the application.
	 *
	 * @return void
	 */
	protected function configureRateLimiting(): void
	{
		RateLimiter::for('api', fn (Request $request) => Limit::perMinute(60)->by($request->user()?->id ?: $request->ip()));
	}
}
