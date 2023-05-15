<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Dormitory;
use Illuminate\Database\Seeder;

class DormitoriesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(): void
	{
		Dormitory::factory(count: 200)->create();
	}
}
