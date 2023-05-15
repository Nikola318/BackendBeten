<?php

declare(strict_types=1);

namespace App\Cron;

use App\Models\{Concurrent, User};
use Illuminate\Console\Scheduling\Schedule;
use App\Notifications\ConcurrentNotification;
use Illuminate\Support\Facades\{DB, Notification};

final class ConcurrentCron
{
	public static function init(Schedule $schedule)
	{
		// We need to get the concurrents in the current time range
		$concurrents_query = Concurrent::select('model_type', 'model_id', 'extra')
			->where('starting_at', '<=', now())
			->where('ending_at', '>=', now());

		if ($concurrents_query->exists()) {
			$concurrents = $concurrents_query->get();
			$daily_concurrents = $concurrents->where('extra.frequency', 'daily');
			foreach ($daily_concurrents as $concurrent) {
				foreach ($concurrent->extra['alerts'] as $alert) {
					$users = [];
					if (array_key_exists('users', $alert['notificants'])) {
						$users = $alert['notificants']['users'];
					}
					if (array_key_exists('roles', $alert['notificants'])) {
						// Get users from the roles and append to the users array
						foreach ($alert['notificants']['roles'] as $role) {
							$users = array_merge(
								$users,
								DB::table('model_has_roles')
									->where([
										'model_type' => User::class,
										'role_id' => $role,
									])
									->select('model_id')
									->pluck('model_id')
									->toArray()
							);
						}
					}
					$schedule->call(
						fn () =>
							// Here we must send the notification to every user
							Notification::send($users, new ConcurrentNotification($concurrent))
					)->dailyAt($alert['time']);
				}
			}
			$weekly = $concurrents->where('extra->frequency', 'weekly');
		}
	}
}
