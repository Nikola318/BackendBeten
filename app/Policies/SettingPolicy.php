<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\{Setting, User};
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view any settings.
	 *
	 * @param \App\Models\User $user
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function viewAny(User $user): bool
	{
		return $user->can('settings.index');
	}

	/**
	 * Determine whether the user can view the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Setting $setting
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function view(User $user, Setting $setting): bool
	{
		return $user->can('settings.view');
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
		return $user->can('settings.create');
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Setting $setting
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function update(User $user, Setting $setting): bool
	{
		return $user->can('settings.edit');
	}

	/**
	 * Determine whether the user can delete the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Setting $setting
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function delete(User $user, Setting $setting): bool
	{
		return $user->can('settings.delete');
	}
}
