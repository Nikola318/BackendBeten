<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\{Service, User};
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view any services.
	 *
	 * @param \App\Models\User $user
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function viewAny(User $user): bool
	{
		return $user->can('services.index');
	}

	/**
	 * Determine whether the user can view the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Service $service
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function view(User $user, Service $service): bool
	{
		return $user->can('services.view');
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
		return $user->can('services.create');
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Service $service
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function update(User $user, Service $service): bool
	{
		return $user->can('services.edit');
	}

	/**
	 * Determine whether the user can delete the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Service $service
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function delete(User $user, Service $service): bool
	{
		return $user->can('services.delete');
	}

	/**
	 * Determine whether the user can restore the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Service $service
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function restore(User $user, Service $service): bool
	{
		return false;
	}

	/**
	 * Determine whether the user can permanently delete the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Service $service
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function forceDelete(User $user, Service $service): bool
	{
		return false;
	}
}
