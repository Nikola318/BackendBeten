<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\{Client, Crew, Group};

class ClientGroupTest extends TestCase
{
	/**
	 * Test adding clients to a group.
	 *
	 * @return void
	 */
	public function test_adding_clients_to_group(): void
	{
		$crew = Crew::factory()->create([
			'country_id' => 1,
			'gender' => 'Male',
		]);
		$group = Group::factory()->create([
			'crew_id' => $crew->id,
		]);
		Client::factory()->count(3)->create();
		$response = $this->postJson(uri: '/api/groups/clients', data: [
			'group_id' => $group->id,
			'clients' => Client::whereNull('group_id')
				->limit(3)
				->select('id')
				->pluck('id')
				->toArray()
		]);

		$response->assertAccepted();
	}

	/**
	 * Test adding clients to a group validation.
	 *
	 * @return void
	 **/
	public function test_adding_clients_to_group_validation(): void
	{
		$response = $this->postJson(uri: '/api/groups/clients');
		$response->assertUnprocessable();
	}

	/**
	 * Test removing clients from a group.
	 *
	 * @return void
	 */
	public function test_removing_clients_from_group(): void
	{
		$crew = Crew::factory()->create([
			'country_id' => 1,
			'gender' => 'Male',
		]);
		$group = Group::factory()->create([
			'crew_id' => $crew->id,
		]);
		Client::factory()->count(3)->create([
			'group_id' => $group->id,
		]);
		$response = $this->deleteJson(uri: '/api/groups/clients', data: [
			'group_id' => $group->id,
			'clients' => Client::where('group_id', $group->id)
				->limit(3)
				->select('id')
				->pluck('id')
				->toArray()
		]);

		$response->assertNoContent();
	}

	/**
	 * Test removing clients from a group validation.
	 *
	 * @return void
	 **/
	public function test_removing_clients_from_a_group_validation(): void
	{
		$response = $this->deleteJson(uri: '/api/groups/clients');
		$response->assertUnprocessable();
	}
}
