<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Crew;

class CrewObserver
{
	/**
	 * Handle the Crew "created" event.
	 *
	 * @param  \App\Models\Crew  $crew
	 * @return void
	 */
	public function created(Crew $crew)
	{
		//
	}

	/**
	 * Handle the Crew "updating" event.
	 *
	 * @param \App\Models\Crew $crew
	 *
	 * @return void
	 */
	public function updating(Crew $crew): void
	{
		if ($crew->user_id && $crew->isDirty('fullname')) {
			$crew->user->update([
				'name' => $crew->fullname
			]);
		}
	}

	/**
	 * Handle the Crew "deleted" event.
	 *
	 * @param  \App\Models\Crew  $crew
	 * @return void
	 */
	public function deleted(Crew $crew)
	{
		//
	}

	/**
	 * Handle the Crew "restored" event.
	 *
	 * @param  \App\Models\Crew  $crew
	 * @return void
	 */
	public function restored(Crew $crew)
	{
		//
	}

	/**
	 * Handle the Crew "force deleted" event.
	 *
	 * @param  \App\Models\Crew  $crew
	 * @return void
	 */
	public function forceDeleted(Crew $crew)
	{
		//
	}
}
