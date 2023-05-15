<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hospitality>
 */
class HospitalityFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'title' => fake()->words(nb: 3, asText: true),
			'description' => fake()->words(nb: 5, asText: true),
			'required_date' => fake()->dateTime,
			'quantity' => fake()->randomFloat(
				nbMaxDecimals: 2,
				min: 1,
				max: 999999
			),
			'received_by' => 1,
		];
	}
}
