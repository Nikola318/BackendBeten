<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Country;

use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(): void
	{
		$json = file_get_contents(database_path('countries.json'));
		$countries = json_decode($json, true);

		foreach ($countries as $country) {
			Country::updateOrCreate(['id' => $country['id']], [
				'id' => $country['id'],
				'title' => $country['name'],
			]);
		}
	}

}
