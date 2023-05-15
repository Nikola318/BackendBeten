<?php

declare(strict_types=1);

namespace Database\Factories;

use Spatie\Permission\Models\Role;
use App\Models\{Concurrent, ServiceCommit, User};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Concurrent>
 */
class ConcurrentFactory extends Factory
{
	/**
	 * Define the concurrent's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		/*
		 * Okay this is gonna be a bit complicated but I hope these comments
		 * will help
		 * First column we need to populate is the starting_at DATETIME
		 * Recurrences should start in the future, so let's add a random
		 * amount of days to now (not today because we want to avoid midnight)
		 */
		$start = now()->addDays(rand(1, 60))
			// These here are for just maximum randomization
			->addHours(rand(1, 24))
			->addMinutes(rand(1, 60))
			->addSeconds(rand(1, 60))
			/*
			 * Immutable because we want to use it for the ending_at at the end
			 * ending_at must be further in the future from starting_at
			 */
			->toImmutable();

		// Next, model type can be any Eloquent model class that Concurrent
		// supports
		$model_type = fake()->randomElement(Concurrent::$model_types);

		if ($model_type == 'App\Models\Servicecommit') {
			$model_type = ServiceCommit::class;
		}


		// Frequency can be either daily or weekly
		// This is added to the extra JSON column below
		// Tree level node 1
		$frequency = fake()->randomElement(['daily', 'weekly']);

		// Every concurrent have multiple notification recepients
		// Either direct users or users who have some role(s)
		// Or both
		$notif_recipients_types = fake()->randomElements(
			array: ['users', 'roles'],
			count: rand(1, 2) // Can be either or both
		);

		$notification_recipients = [
			'roles' => Role::select('id')->inRandomOrder()
				->limit(rand(1, 10))->pluck('id')->toArray(),
			'users' => User::select('id')->inRandomOrder()
				->limit(rand(1, 10))->pluck('id')->toArray(),
		];

		// If the random frequency type for the current concorrent in iteration
		// is daily then we can create up to 9 alerts
		// Each alert has a time and window, roles and users
		if ($frequency === 'daily') {
			for ($alert = 0; $alert <= rand(1, 9); $alert++) {
				$frequency_params['alerts'][$alert]['time'] = fake()->time(format: 'H:i');
				// Max should be midnight - time / 2
				$frequency_params['alerts'][$alert]['window'] = rand(min: 10, max: 60);
				// Notificants can be array(s) of users and/or roles
				$frequency_params['alerts'][$alert]['notificants'] = $notification_recipients;
			}
		} else { // Weekly recurring frequency
			$days_indexes = fake()->randomElements(range(1, 7), rand(1, 7));
			$frequency_params = [];

			foreach ($days_indexes as $day_index) {
				$day = now()->addDays($day_index)->format('l');

				$frequency_params[$day] = [
					'time' => fake()->time(format: 'H:i'),
				];

				foreach ($notif_recipients_types as $type) {
					$frequency_params[$day][$type] = $notification_recipients[$type];
				}
			}
		}
		// if daily, the next keys in the extra column should be time then window
		// time is self-explanatory
		// window should be an unsigned integer in minutes
		// So if model_type is meal and time is 20:00 (dinner for ex)
		// The window being 30 minutes
		// means that the dinner is available from 19:30 to 20:31
		// -------------------------------------------------------
		// if weekly, the next keys in the extra column should be every day from
		// Sat to Fri => assoc time for each
		// For each day as well we have an assoc array of roles and/or users to
		// be notified (but must select at least one role or one user)
		$extra = ['frequency' => $frequency];
		return [
			'starting_at' => $start,
			'ending_at' => $start->addDays(rand(1, 60)),
			'model_type' => $model_type,
			'model_id' => (new $model_type)->inRandomOrder()->select('id')
				->limit(1)->value('id'),
			'extra' => array_merge($extra, $frequency_params),
		];
	}
}
