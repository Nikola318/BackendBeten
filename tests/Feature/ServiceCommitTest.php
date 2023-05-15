<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\{Service, ServiceCommit};

class ServiceCommitTest extends TestCase
{
	/**
	 * Test releasing a service commit
	 *
	 * @return void
	 */
	public function test_releasing_a_service_commit(): void
	{
		Service::factory()->create();
		$commit = ServiceCommit::factory()->create([
			'started_at' => now(),
		]);
		$response = $this->postJson(
			uri: '/api/service_commits/release/',
			data: ['id' => $commit->id],
		);

		$this->assertNotNull($commit->refresh()->ended_at);

		$response->assertNoContent();
	}
}
