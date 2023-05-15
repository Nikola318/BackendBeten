<?php

declare(strict_types=1);

namespace App\Models;

use DateTimeInterface;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Traits\HasDocuments;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\{HasMany, HasOne};

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property bool $is_active
 * @property string $contact
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Crew|null $crew
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ServiceCommit> $service_commits
 * @property-read int|null $service_commits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
	use HasApiTokens, HasDocuments, HasFactory, HasRoles, Notifiable, SoftDeletes;

	/**
	 * The accessors to append to the model's array form.
	 *
	 * @var array
	 */
	protected $appends = ['is_admin', 'is_supervisor'];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
		'password',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array
	 */
	protected $casts = [
		'is_active' => 'boolean',
	];

	/**
	 * Prepare a date for array / JSON serialization.
	 *
	 * @return string date formatted
	 */
	protected function serializeDate(DateTimeInterface $date): string
	{
		return $date->format('Y-m-d H:i:s');
	}

	/**
	 * Determine if the user is an administrator.
	 *
	 * @return \Illuminate\Database\Eloquent\Casts\Attribute
	 */
	protected function isAdmin(): Attribute
	{
		return new Attribute(
			get: fn () => $this->hasRole('admin'),
		);
	}

	/**
	 * Determine if the user is a supervisor of some group.
	 *
	 * @return \Illuminate\Database\Eloquent\Casts\Attribute
	 */
	protected function isSupervisor(): Attribute
	{
		$supervisor_ids = Group::select('crew_id')
			->distinct()
			->pluck('crew_id')
			->toArray();

		$user_ids = Crew::select('user_id')
			->whereIn('id', $supervisor_ids)
			->pluck('user_id');

		return new Attribute(
			get: fn () => $user_ids->contains($this->id),
		);
	}

	/**
	 * Get the crew member of the user
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function crew(): HasOne
	{
		return $this->hasOne(related: Crew::class);
	}

	/**
	 * Get service commits assigned to the user (as supervisor).
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function service_commits(): HasMany
	{
		return $this->hasMany(ServiceCommit::class, 'supervisor_id');
	}
}
