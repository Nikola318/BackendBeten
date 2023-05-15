<?php

declare(strict_types=1);

namespace Database\Factories;

use Faker\Provider\Fakecar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		fake()->addProvider(new Fakecar($this->faker));
		$vehicle = fake()->vehicleArray();
		return [
			'model' => $vehicle['model'],
			'manufacturer' => $vehicle['brand'],
			'year' => fake()->biasedNumberBetween(1990, date('Y'), 'sqrt'),
			'registration' => fake()->vehicleRegistration,
			'badge' => fake()->numerify('########'),
			'passengers' => fake()->optional()->numberBetween(2, 50),
		];
	}
}
