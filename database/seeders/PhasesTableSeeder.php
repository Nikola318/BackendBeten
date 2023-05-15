<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Phase, Service};

class PhasesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(): void
	{
		Phase::factory(count: 20)->create()->each(function (Phase $phase) {
			$phase->services()->attach(
				Service::inRandomOrder()
					->limit(5)
					->select('id')
					->pluck('id')
					->toArray()
			);
		});
	}
}
