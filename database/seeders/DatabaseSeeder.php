<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{City, ServiceCommit, Setting, Vehicle};

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run(): void
	{
		// We should probably seed client_languages before seeding clients
		// At the moment the two tables are not related
		$this->call([
			CitiesTableSeeder::class,
			PermissionsTableSeeder::class,
			RolesTableSeeder::class,
			CountrySeeder::class,
			ProfessionsTableSeeder::class,
			UsersTableSeeder::class, // Also seeds crew member
			GroupsTableSeeder::class,
			HospitalitiesTableSeeder::class,
			ServicesTableSeeder::class,
			PhasesTableSeeder::class,
			MealTypesTableSeeder::class,
			MealsTableSeeder::class,
			CrewMembersTableSeeder::class,
			ClientsTableSeeder::class,
			DormitoriesTableSeeder::class,
		]);
		Vehicle::factory(count: 20)->create();
		Setting::factory(count: 5)->create();
		ServiceCommit::factory(count: 5)->create();
		$this->call([
			ConcurrentsTableSeeder::class,
		]);
	}
}
