<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\{Contract, Document};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meal>
 */
class MealFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'meal_type_id' => rand(1, 20), // Already seeded 20 types
			'quantity' => fake()->randomNumber(),
			'to_model_type' => fake()->randomElement(
				array_merge(Contract::$model_types, Document::$model_types)
			),
			'to_model_id' => fake()->randomNumber(),
			'sent_at' => fake()->dateTime,
		];
	}
}
