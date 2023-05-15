<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\{Service, User};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceCommit>
 */
class ServiceCommitFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'service_id' => Service::select('id')
				->inRandomOrder()
				->limit(1)
				->value('id'),
			'badge' => fake()->iban,
			'schedule_at' => fake()->dateTime,
			'from_location' => fake()->city,
			'supervisor_id' => User::select('id')
				->inRandomOrder()
				->limit(1)
				->value('id'),
		];
	}
}
