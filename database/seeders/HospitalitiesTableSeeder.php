<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Hospitality;
use Illuminate\Database\Seeder;

class HospitalitiesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(): void
	{
		Hospitality::factory(count: 20)->create();
	}
}
