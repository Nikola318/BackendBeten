<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MealType>
 */
class MealTypeFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'title' => fake()->words(nb: 5, asText: true),
			'description' => fake()->words(nb: 10, asText: true),
			'has_documents' => fake()->boolean(chanceOfGettingTrue: 50),
		];
	}
}
