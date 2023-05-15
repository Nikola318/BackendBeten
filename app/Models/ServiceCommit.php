<?php

declare(strict_types=1);

namespace App\Models;

use DateTimeInterface;
use App\Models\Traits\HasConcurrent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\ServiceCommit
 *
 * @property int $id
 * @property int $service_id
 * @property string $badge
 * @property \Illuminate\Support\Carbon $schedule_at
 * @property \Illuminate\Support\Carbon|null $started_at
 * @property string|null $ended_at
 * @property string $from_location
 * @property int $supervisor_id user_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $phase_id
 * @property-read \App\Models\Phase|null $phase
 * @property-read \App\Models\Service $service
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Service_Commit_Log> $service_commit_log
 * @property-read int|null $service_commit_log_count
 * @property-read \App\Models\User|null $supervisor
 * @method static \Database\Factories\ServiceCommitFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCommit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCommit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCommit query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCommit whereBadge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCommit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCommit whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCommit whereFromLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCommit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCommit wherePhaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCommit whereScheduleAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCommit whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCommit whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCommit whereSupervisorId($value)
 * @mixin \Eloquent
 */
class ServiceCommit extends Model
{
	use HasConcurrent, HasFactory;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'service_commits';

	/**
	 * The name of the "updated at" column.
	 *
	 * @var string|null
	 */
	const UPDATED_AT = null;

	/**
	 * The attributes that should be cast.
	 *
	 * @var array
	 */
	protected $casts = [
		'schedule_at' => 'datetime',
		'started_at' => 'datetime',
	];

	/**
	 * Prepare a date for array / JSON serialization.
	 */
	protected function serializeDate(DateTimeInterface $date): string
	{
		return $date->format('Y-m-d H:i:s');
	}

	/**
	 * Get the service this commit belongs to
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function service(): BelongsTo
	{
		return $this->belongsTo(Service::class);
	}

	/**
	 * Service commit supervisor
	 *
	 * Get the supervisor user of the service commit
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 **/
	public function supervisor(): BelongsTo
	{
		return $this->belongsTo(User::class, 'supervisor_id');
	}

	public function service_commit_log()
	{
		return $this->hasMany(Service_Commit_Log::class, 'service_commit_id', 'id');
	}

	public function phase()
	{
		return $this->belongsTo(Phase::class);
	}
}
