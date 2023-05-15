<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		// Must get a random gender to apply for the name
		$gender = fake()->randomElement(array: ['Male', 'Female']);
		$name = fake()->firstName($gender) . ' ' . fake()->lastName;
		return [
			'fullname' => $name,
			'country_id' => fake()->numberBetween(1, 225),
			'id_type' => fake()->randomElement(array: [
				'Passport',
				'Government ID',
				'Driver License',
				'Social Security Number',
			]),
			'id_number' => fake()->numerify(string: '##########'),
			'id_name' => $name,
			'gender' => $gender,
			'dob' => fake()->date,
			'phone' => fake()->phoneNumber,
			'is_handicap' => fake()->boolean(chanceOfGettingTrue: 7),
		];
	}
}
