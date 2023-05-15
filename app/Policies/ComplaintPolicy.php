<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\{Complaint, User};
use Illuminate\Auth\Access\HandlesAuthorization;

class ComplaintPolicy
{
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view any complaints.
	 *
	 * @param \App\Models\User $user
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function viewAny(User $user): bool
	{
		return $user->can('complaints.index');
	}

	/**
	 * Determine whether the user can view the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Complaint $complaint
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function view(User $user, Complaint $complaint): bool
	{
		return $user->can('complaints.view');
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
		return $user->can('complaints.create');
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Complaint $complaint
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function update(User $user, Complaint $complaint): bool
	{
		return $user->can('complaints.edit');
	}

	/**
	 * Determine whether the user can delete the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Complaint $complaint
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function delete(User $user, Complaint $complaint): bool
	{
		return $user->can('complaints.delete');
	}
}
