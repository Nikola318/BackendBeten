<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Crew;
use App\Observers\CrewObserver;
use Illuminate\Support\ServiceProvider;

class ObservserServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot(): void
	{
		Crew::observe(CrewObserver::class);
	}
}
