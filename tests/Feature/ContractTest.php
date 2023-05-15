<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\{Crew, User};
use Laravel\Sanctum\Sanctum;
use Illuminate\Http\UploadedFile;

class ContractTest extends TestCase
{
	/**
	 * Test contract file validation
	 *
	 * @return void
	 */
	public function test_create_contract_file_validation(): void
	{
		Crew::factory()->create([
			'gender' => 'Male',
		]);
		Sanctum::actingAs(user: User::first());
		$response = $this->postJson(uri: '/api/contracts/crew/1', data: [
			'model_id' => 1,
			'reference' => fake()->iban,
			'contracts' => [
				UploadedFile::fake()
					->create(
						name: 'document.docx',
						kilobytes: 1024,
						mimeType: 'application/msword'
					),
			],
		]);

		$response->assertJsonValidationErrorFor(key: 'contracts.0');

		$response->assertUnprocessable();
	}
}
