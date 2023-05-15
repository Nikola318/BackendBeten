<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Crew;
use Illuminate\Database\Seeder;

class CrewMembersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(): void
	{
		Crew::factory(count: 20)->create();
	}
}
