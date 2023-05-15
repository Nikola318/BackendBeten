<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view any roles.
	 *
	 * @param \App\Models\User $user
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function viewAny(User $user): bool
	{
		return $user->can('roles.index');
	}

	/**
	 * Determine whether the user can view the model.
	 *
	 * @param \App\Models\User $user
	 * @param \Spatie\Permission\Models\Role $role
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function view(User $user, Role $role): bool
	{
		return $user->can('roles.view');
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
		return $user->can('roles.create');
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param \App\Models\User $user
	 * @param \Spatie\Permission\Models\Role $role
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function update(User $user, Role $role): bool
	{
		return $user->can('roles.edit');
	}

	/**
	 * Determine whether the user can delete the model.
	 *
	 * @param \App\Models\User $user
	 * @param \Spatie\Permission\Models\Role $role
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function delete(User $user, Role $role): bool
	{
		return $user->can('roles.delete');
	}

	/**
	 * Determine whether the user can restore the model.
	 *
	 * @param \App\Models\User $user
	 * @param \Spatie\Permission\Models\Role $role
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function restore(User $user, Role $role): bool
	{
		return false;
	}

	/**
	 * Determine whether the user can permanently delete the model.
	 *
	 * @param \App\Models\User $user
	 * @param \Spatie\Permission\Models\Role $role
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function forceDelete(User $user, Role $role): bool
	{
		return false;
	}
}
