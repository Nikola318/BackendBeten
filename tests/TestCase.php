<?php

declare(strict_types=1);

namespace Tests;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\{RefreshDatabase, TestCase as BaseTestCase};

abstract class TestCase extends BaseTestCase
{
	use CreatesApplication, RefreshDatabase;

	/**
	 * Setup the test environment.
	 *
	 * @return void
	 */
	protected function setUp(): void
	{
		parent::setUp();
		// Create an admin user
		Role::create(['name' => 'admin']);
		Artisan::call('db:seed --class=CountrySeeder');
		Sanctum::actingAs(user: User::factory()->create()->assignRole('admin'));
	}
}
