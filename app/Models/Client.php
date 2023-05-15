<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasDocuments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

/**
 * App\Models\Client
 *
 * @property int $id
 * @property int|null $group_id
 * @property string $fullname Arabic language
 * @property int $country_id
 * @property string $id_type
 * @property string $id_number
 * @property string $id_name
 * @property string $gender
 * @property \Illuminate\Support\Carbon $dob
 * @property string $phone
 * @property bool $is_handicap
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Country|null $country
 * @property-read \App\Models\Group|null $group
 * @method static \Database\Factories\ClientFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Client query()
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereFullname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereIdName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereIdNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereIdType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereIsHandicap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Client withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ClientLog> $logs
 * @property-read int|null $logs_count
 * @mixin \Eloquent
 */
class Client extends Model
{
	use HasDocuments, HasFactory, SoftDeletes;

	/**
	 * The single value that should be used to represent the model when being displayed.
	 *
	 * @var string
	 */
	public static string $title = 'fullname';

	/**
	 * The attributes that should be cast.
	 *
	 * @var array
	 */
	protected $casts = [
		'is_handicap' => 'boolean',
		'dob' => 'date:Y-m-d',
	];

	/**
	 * Get the country from which the client came (phrasing)
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function country(): BelongsTo
	{
		return $this->belongsTo(Country::class);
	}

	/**
	 * Get the group the client is a part of
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function group(): BelongsTo
	{
		return $this->belongsTo(related: Group::class);
	}

	/**
	 * Get the logs of the client
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function logs(): HasMany
	{
		return $this->hasMany(related: ClientLog::class);
	}
}
