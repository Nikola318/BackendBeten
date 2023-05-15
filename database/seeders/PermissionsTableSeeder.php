<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(): void
	{
		// Reset cached roles and permissions
		app()[PermissionRegistrar::class]->forgetCachedPermissions();

		$entities = [
			'clients',
			'service_commits',
			'complaints',
			'crews',
			'dormitories',
			'evaluations',
			'groups',
			'hospitalities',
			'logs',
			'meals',
			'phases',
			'services',
			'transactions',
			'types',
			'users',
			'vehicles',
			'roles',
		];

		$relatables = [
			'contracts',
			'documents',
			'concurrents',
		];

		$actions = [
			'index',
			'view',
			'create',
			'edit',
			'delete',
			'*',
		];

		foreach ($entities as $entity) {
			foreach ($actions as $action) {
				Permission::create(['name' => $entity . '.' . $action]);
				if ($entity != 'roles') {
					foreach ($relatables as $relatable) {
						Permission::create([
							'name' => $entity . '.' . $relatable . '.' . $action,
						]);
					}
				}
			}
		}

		foreach ([
			'user_logs.view',
			'user_logs.index',
			'users_dataentry.view',
			'users_dataentry.index',
			'settings.view',
			'settings.edit',
			'settings.index',
		] as $permission) {
			Permission::create(['name' => $permission]);
		}

		Permission::create(['name' => 'groups.clients.add']);
		Permission::create(['name' => 'groups.clients.remove']);
		Permission::create(['name' => 'service_commits.initialize']);
		Permission::create(['name' => 'service_commits.release']);
	}
}
