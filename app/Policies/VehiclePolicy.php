<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\{User, Vehicle};
use Illuminate\Auth\Access\HandlesAuthorization;

class VehiclePolicy
{
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view any vehicles.
	 *
	 * @param \App\Models\User $user
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function viewAny(User $user): bool
	{
		return $user->can('vehicles.index');
	}

	/**
	 * Determine whether the user can view the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Vehicle $vehicle
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function view(User $user, Vehicle $vehicle): bool
	{
		return $user->can('vehicles.view');
	}

	/**
	 * Determine whether the user can create models.
	 *
	 * @param \App\Models\User $user
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function create(User $user): bool
	{
		return $user->can('vehicles.create');
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Vehicle $vehicle
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function update(User $user, Vehicle $vehicle): bool
	{
		return $user->can('vehicles.edit');
	}

	/**
	 * Determine whether the user can delete the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Vehicle $vehicle
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function delete(User $user, Vehicle $vehicle): bool
	{
		return $user->can('vehicles.delete');
	}

	/**
	 * Determine whether the user can restore the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Vehicle $vehicle
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function restore(User $user, Vehicle $vehicle): bool
	{
		return false;
	}

	/**
	 * Determine whether the user can permanently delete the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Vehicle $vehicle
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function forceDelete(User $user, Vehicle $vehicle): bool
	{
		return false;
	}
}
