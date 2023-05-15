<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view any users.
	 *
	 * @param \App\Models\User $user
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function viewAny(User $user): bool
	{
		return $user->can('users.index');
	}

	/**
	 * Determine whether the user can view the user.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\User $model
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function view(User $user, User $model): bool
	{
		return $user->can('users.view');
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
		return $user->can('users.create');
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\User $model
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function update(User $user, User $model): bool
	{
		return $user->can('users.edit') && !$model->is_admin;
	}

	/**
	 * Determine whether the user can delete the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\User $model
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function delete(User $user, User $model): bool
	{
		return $user->can('users.delete') && !$model->is_admin;
	}

	/**
	 * Determine whether the user can restore the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\User $model
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function restore(User $user, User $model): bool
	{
		return false;
	}

	/**
	 * Determine whether the user can permanently delete the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\User $model
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function forceDelete(User $user, User $model): bool
	{
		return false;
	}
}
