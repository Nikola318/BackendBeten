<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\{Client, Crew, Group, User};
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view any clients.
	 *
	 * @param \App\Models\User $user
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function viewAny(User $user): bool
	{
		return $user->can('clients.index');
	}

	/**
	 * Determine whether the user can view the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Client $client
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function view(User $user, Client $client): bool
	{
		$crew_id = Group::whereId($client->group_id)
			->select('crew_id')
			->value('crew_id');
		return $user->can('clients.view') || Crew::whereId($crew_id)
			->select('user_id')->value('user_id') === $user->id;
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
		return $user->can('clients.create');
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Client $client
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function update(User $user, Client $client): bool
	{
		return $user->can('clients.edit');
	}

	/**
	 * Determine whether the user can delete the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Client $client
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function delete(User $user, Client $client): bool
	{
		return $user->can('clients.delete');
	}

	/**
	 * Determine whether the user can restore the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Client $client
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function restore(User $user, Client $client): bool
	{
		return false;
	}

	/**
	 * Determine whether the user can permanently delete the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Client $client
	 *
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function forceDelete(User $user, Client $client): bool
	{
		return false;
	}
}
