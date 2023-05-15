<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(): void
	{
		Role::create(['name' => 'admin']);
		Role::create(['name' => 'user']);

		Role::create(['name' => 'supervisor'])->givePermissionTo([
			'users.*',
			'crews.*',
			'vehicles.*',
			'clients.*',
		]);

		Role::create(['name' => 'groups-admin'])->givePermissionTo([
			'groups.*',
			'clients.*',
		]);


		Role::create(['name' => 'member'])->givePermissionTo([
			'users.*',

			'crews.index',
			'crews.view',

			'vehicles.index',
			'vehicles.view',
		]);
	}
}
