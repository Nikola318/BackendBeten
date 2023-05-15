<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Concurrent;
use Illuminate\Database\Seeder;

class ConcurrentsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(): void
	{
		Concurrent::factory(count: 20)->create();
	}
}
