<?php

declare(strict_types=1);

namespace App\Models;

use DateTimeInterface;
use App\Models\Traits\{HasContracts, HasDocuments};
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

/**
 * App\Models\Crew
 *
 * @property int $id
 * @property string $fullname name in arabic language
 * @property int $gender 0->male, 1->female
 * @property int|null $profession_id
 * @property int $country_id
 * @property string $phone
 * @property string $id_type
 * @property string $id_number
 * @property string $dob
 * @property int $is_active
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Country|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document> $documents
 * @property-read int|null $documents_count
 * @method static \Illuminate\Database\Eloquent\Builder|Crew countryName()
 * @method static \Database\Factories\CrewFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Crew newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Crew newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Crew query()
 * @method static \Illuminate\Database\Eloquent\Builder|Crew whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crew whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crew whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crew whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crew whereFullname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crew whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crew whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crew whereIdNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crew whereIdType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crew whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crew wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crew whereProfessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crew whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contract> $contracts
 * @property-read int|null $contracts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document> $documents
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|Crew onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Crew whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crew withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Crew withoutTrashed()
 * @property string $id_name
 * @method static \Illuminate\Database\Eloquent\Builder|Crew whereIdName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crew whereIdNumber($value)
 * @mixin \Eloquent
 */
class Crew extends Model
{
	use HasContracts, HasDocuments, HasFactory, SoftDeletes;

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
		// dob = Date Of Birth (was too much to name it birthday apparently)
		'dob' => 'date:Y-m-d',
		'is_active' => 'boolean',
	];

	/*
	 * Local Query scope
	 *
	 * @param $query
	 */
	public function scopeCountryName($query)
	{
		return $query->addSelect(['country_name' => Country::select('name')
					 ->whereColumn('country_id', 'countries.id')
					 ->limit(1)
		]);
	}

	/**
	 * Get the country of the crew member.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function country(): BelongsTo
	{
		return $this->belongsTo(Country::class);
	}

	/**
	 * Get the user of the crew member.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * Prepare a date for array / JSON serialization.
	 *
	 * @param \DateTimeInterface $date date object to format
	 *
	 * @return string formatted date as string
	 */
	protected function serializeDate(DateTimeInterface $date): string
	{
		return $date->format('Y-m-d H:i:s');
	}
}
