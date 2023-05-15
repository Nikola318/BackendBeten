<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Meal;
use Illuminate\Database\Seeder;

class MealsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(): void
	{
		Meal::factory(count: 100)->create();
	}
}
