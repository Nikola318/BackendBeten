<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\{Country, Profession};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Crew>
 */
class CrewFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		// Must get a random gender to apply for the name
		$gender = fake()->randomElement(array: ['male', 'female']);
		$fullname = fake()->firstName($gender) . ' ' . fake()->lastName;
		return [
			'fullname' => $fullname,
			'gender' => $gender,
			'profession_id' => Profession::select('id')
				->inRandomOrder()
				->limit(1)
				->value('id'),
			'country_id' => Country::select('id')
				->inRandomOrder()
				->limit(1)
				->value('id'),
			'phone' => fake()->optional()->phoneNumber,
			'id_type' => 'Passport',
			'id_name' => fake(locale: 'en_US')->firstName($gender) . ' ' . fake(locale: 'en_US')->lastName,
			'id_number' => fake()->iban,
			'dob' => fake()->optional()->date,
			'is_active' => fake()->boolean,
		];
	}
}
