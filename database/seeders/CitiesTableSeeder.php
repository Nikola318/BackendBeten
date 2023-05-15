<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(): void
	{
		$cities = [
			'جدة',
			'مكة المكرمة',
			'المدينة المنورة',
			'الرياض',
		];
		foreach ($cities as $city) {
			City::create([
				'title' => $city,
			]);
		}
	}
}
