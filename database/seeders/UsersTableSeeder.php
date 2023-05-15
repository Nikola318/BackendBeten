<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(): void
	{
		// Seed static email admin user for easier development
		User::factory()->create([
			'name' => 'Dr. Imad',
			'email' => 'admin@murafiq.com',
			'is_active' => true,
		])->assignRole('admin');

		User::factory()->create([
			'email' => 'supervisor@murafiq.com',
			'is_active' => true,
		])->assignRole('supervisor');

		User::factory()->create([
			'email' => 'groups-admin@murafiq.com',
			'is_active' => true,
		])->assignRole('groups-admin');

		User::factory()->create([
			'email' => 'member@murafiq.com',
			'is_active' => true,
		])->assignRole('member');

		User::factory()->count(20)->hasCrew()->create();
	}
}
